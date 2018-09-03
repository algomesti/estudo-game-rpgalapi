<?php

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/vendor/autoload.php';

session_start();
require_once 'config/config.php';

$settings['settings'] = $config;

$app = new \Slim\App($settings);

require __DIR__ . '/config/dependencies.php';

require __DIR__ . '/routes.php';

$app->run();
