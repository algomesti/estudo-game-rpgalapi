<?php

$app->get('/[{name}]', 'App\Action\Main:index');
$app->get('/play/', 'App\Action\Main:play');
$app->get('/token/{token}', 'App\Action\Main:token');
$app->get('/start/{token}', 'App\Action\Main:start');
$app->get('/fight/{token}', 'App\Action\Main:fight');
