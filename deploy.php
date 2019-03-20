<?php
namespace Deployer;

require 'recipe/symfony.php';

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

host('webrush.fr')
    ->user('adrien')
    ->port($SSH_PORT)
    ->set('deploy_path', 'var/www/{{application}}');    
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

task('pwd', function () {
    $result = run('pwd');
    writeln("Current dir: $result");
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

