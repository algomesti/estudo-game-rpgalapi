<?php

$app->get('/[{name}]', 'App\Action\Main:index');
$app->get('/play/', 'App\Action\Main:play');
$app->get('/token/{token}', 'App\Action\Main:token');
