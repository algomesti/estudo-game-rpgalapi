<?php
use Monolog\Logger as logger;
define('APPNAME','rpgalcli');

define('LOG_NAME', APPNAME );
define('LOG_PATH', isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log' );
define('LOG_LEVEL', logger::DEBUG );

define('API_HOST', 'localhost');
define('API_PORT', 80);


