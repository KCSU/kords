<?php
namespace Deployer;

// Include the Laravel & rsync recipes
require 'recipe/laravel.php';
require 'contrib/rsync.php';

set('application', 'kords');
set('ssh_multiplexing', true); // Speeds up deployments

set('rsync_src', function () {
    return __DIR__; // If your project isn't in the root, you'll need to change this.
});
set('http_group', 'kcsu');
set('writable_mode', 'chgrp');
set('keep_releases', 1); // TODO: should this be 2?
// Configuring the rsync exclusions.
// You'll want to exclude anything that you don't want on the production server.
add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

// Set up a deployer task to copy secrets to the server.
// Since our secrets are stored in GitHub, we can access them as env vars.
task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    $dir = get('deploy_path') . '/shared';
    upload('.env', $dir);
    run("chmod o-rwx $dir/.env");
});

// Hosts
host('kords.kcsu.org.uk') // Name of the server
->setHostname('shell.srcf.net') // Hostname or IP address
->set('labels', ['stage' => 'production']) // Deployment stage (production, staging, etc)
->setRemoteUser(getenv('SRCF_USER')) // SSH user, TODO: change
->setDeployPath('~/kcsu/public_html/kords'); // Deploy path

after('deploy:failed', 'deploy:unlock'); // Unlock after failed deploy

desc('Deploy the application');
task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'rsync', // Deploy code & built assets
    'deploy:secrets', // Deploy secrets
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link', // |
    'artisan:view:cache',   // |
    'artisan:config:cache', // | Laravel specific steps
    'artisan:optimize',     // |
    'artisan:migrate',      // |
    'deploy:symlink',
    'deploy:unlock',
    'deploy:cleanup',
]);