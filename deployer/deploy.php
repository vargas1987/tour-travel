<?php

namespace Deployer;

require 'recipe/symfony3.php';

// Project name
set('application', 'system.altezza.travel');
// Project repository
set('repository', 'git@bitbucket.org:altezzatravel/altezza-hotels-data-base.git');

set('ssh_multiplexing', true);
set('use_atomic_symlink', false);
set('keep_releases', 3);
set('allow_anonymous_stats', false);
set('symfony_env', 'prod');
set('bin_dir', 'bin');
set('release_name', date('YmdHis'));

add('shared_files', ['app/config/parameters.yml']);
add('shared_dirs', ['var/logs', 'var/sessions']);
add('writable_dirs', ['var/cache', 'var/logs', 'var/sessions']);
add('clear_paths', ['deployer', '.git']);

// Hosts
host('80.87.199.111')
    ->user('protorp')
    ->set('deploy_path', '~/sites/{{application}}')
    ->set('deploy_release', 'altezza.presta-studio.ru')
    ->stage('stage')
    ->roles('db');

host('laveo.ftp.tools')
    ->user('laveo')
    ->set('http_user', 'laveo')
    ->set('writable_mode', 'chown')
    ->set('deploy_path', '~/altezza.travel/{{application}}')
    ->set('deploy_release', 'hotels')
    ->set('bin/php', '/usr/local/php70/bin/php')
    ->stage('uahost')
    ->roles('db');

host('185.233.116.225')
    ->user('altezza')
    ->set('http_user', 'altezza')
    ->set('writable_mode', 'chown')
    ->set('deploy_path', '/srv/{{application}}')
    ->stage('prod')
    ->roles('db');

// Migrate database before symlink new release.
task('database:migrate')->onRoles('db');

task('deploy:not_symlink', function () {
    run("cd {{deploy_path}} && {{bin/symlink}} {{release_path}} ../{{deploy_release}}"); // Atomic override symlink.
    run("cd {{deploy_path}} && rm release"); // Remove release link.
})->onStage('stage', 'uahost');

task('deploy:crontab:clear', function () {
    run("crontab -r || true");
})->onStage('prod')->onRoles('db');

task('deploy:crontab:set', function () {

    run("/usr/bin/crontab {{release_path}}/bin/crontab");
})->onStage('prod');

before('database:migrate', 'deploy:crontab:clear');
after('deploy:symlink', 'deploy:crontab:set');

task('deploy:symlink')->onStage('prod');

after('deploy:symlink', 'deploy:not_symlink');
before('deploy:symlink', 'database:migrate');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
