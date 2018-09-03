<?php

$container = $app->getContainer();

$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['redis'] = function ($c) {
    $settings = $c->get('settings')['redis'];
    $redis = new \Predis\Client(array("host"=>$settings['host'], "port"=>$settings['port']));
   return $redis;
};
