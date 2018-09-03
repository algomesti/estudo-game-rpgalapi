<?php
use Monolog\Logger as logger;
define('APPNAME','rpgalapi');

define('LOG_NAME', APPNAME );
define('LOG_PATH', isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log' );
define('LOG_LEVEL', logger::DEBUG );

define('REDIS_HOST', 'localhost');
define('REDIS_PORT', 6379);



