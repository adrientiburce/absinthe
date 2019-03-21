<?php
namespace Deployer;

require 'recipe/symfony.php';
require './deploy_env.php';


// Project name
set('application', 'absinthe');

// Project repository
set('repository', 'git@github.com:adrientiburce/absinthe.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
host($SERVER)
    ->user($SSH_NAME)
    ->port($SSH_PORT)
    ->stage('production')
    ->set('deploy_path', 'var/www/{{application}}');    
    
// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

task('test', function () {
    writeln("Hello ");
});

task('build-local', function () {
    run("./node_modules/.bin/encore production");
    run("./node_modules/.bin/encore production --config webpack.config.serverside.js");
    writeln("Build done!");
})->local();

task('build', '
    ./node_modules/.bin/encore production;
    ./node_modules/.bin/encore production --config webpack.config.serverside.js;
    echo "Build done";
')->local();

task('pwd', function () {
    $result = run('pwd');
    writeln("Current dir: $result");
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'database:migrate');

