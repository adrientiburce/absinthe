<?php
namespace Deployer;

require 'recipe/symfony.php';
require './deploy_env.php';


// Project name
set('application', 'new-absinthe');

// Project repository
set('repository', 'git@github.com:adrientiburce/absinthe.git');
set('branch', 'master');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', ['.env.prod.local']);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', ['public/course', 'var']);
set('allow_anonymous_stats', false);

// Hosts
host($SERVER)
    ->user($SSH_NAME)
    ->port($SSH_PORT)
    ->stage('production')
    ->set('deploy_path', '/var/www/{{application}}')
    ->set('env', [
        'APP_ENV'=>'prod',
        ]);
    
task('test', function () {
    writeln("Hello ");
});

set('bin/console', function () {
    return parse('{{bin/php}} {{release_path}}/bin/console --no-interaction');
});

task('database:migrate', function () {
    $options = '--allow-no-migration';
    if (get('migrations_config') !== '') {
        $options = sprintf('%s --configuration={{release_path}}/{{migrations_config}}', $options);
    }
    $options = "";
    run(sprintf('{{bin/console}} doctrine:migrations:migrate %s', $options));
});

task('deploy:build-prod', function () {
    run("cd {{release_path}} && ./node_modules/.bin/encore production");
    run("cd {{release_path}} && ./node_modules/.bin/encore production --config webpack.config.serverside.js");
});

task('deploy:vendors', function () {
    // Your custom update code
    run("export APP_ENV='prod'; cd {{release_path}} && composer install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader; npm install");
});

task('deploy:cache:clear', function() {
    run("cd {{release_path}} && rm -fr var/cache/prod && rm -fr var/cache/dev");
});

// task('deploy:cache:warmup', function() {
//     run("export APP_ENV='prod'; cd {{release_path}} && APP_ENV=prod APP_DEBUG=0 php bin/console cache:warmup");
// });

task('deploy:change:acl', function() {
    run("cd {{release_path}} && setfacl -Rm 'u:www-data:rwx' var/ && setfacl -Rm 'u:www-data:rwx' var/");
    run("cd {{release_path}} && setfacl -Rm 'u:www-data:rwx' public/course && setfacl -Rm 'u:www-data:rwx' public/course");
});

task('update:env', function () {
    run("echo 'DATABASE_URL=mysql://adrient:joncyclesu adrien@127.0.0.1:3306/absinthe' > .env.prod.local");
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// we enable env variables for prod
after('update_code', 'update:env');

// Migrate database before symlink new release.
// before('deploy:symlink', 'database:migrate');
after('deploy:symlink', 'database:migrate');
/**
 * Main task
 */
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:clear_paths',
    'deploy:create_cache_dir',
    'deploy:shared',
    'deploy:assets', 
    'deploy:vendors',
    'deploy:build-prod', // build with encore 
    'deploy:assetic:dump',
    'deploy:cache:clear',
    // 'deploy:cache:warmup', //issue with own after cache:warmup www-data :no acces
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);
