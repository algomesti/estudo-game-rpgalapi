<?php
require __DIR__ . '/Action/Action.php';
require __DIR__ . '/Action/Main.php';

$app->get('/', 'App\Action\Main:play');
$app->get('/play/', 'App\Action\Main:play');

$app->get('/token/{token}', 'App\Action\Main:token');
$app->get('/start/{token}', 'App\Action\Main:start');
$app->get('/fight/{token}', 'App\Action\Main:fight');
