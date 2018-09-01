<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();
require_once '../config/config.php';

// Instantiate the app
//$settings = require __DIR__ . '/../src/settings.php';

$settings['settings'] = $config;

$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../config/dependencies.php';

// Register middleware
require __DIR__ . '/../middleware.php';

// Register routes
require __DIR__ . '/../Action/Action.php';
require __DIR__ . '/../Action/Main.php';
require __DIR__ . '/../routes.php';

// Run app
$app->run();
