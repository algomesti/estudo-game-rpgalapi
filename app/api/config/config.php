<?php
require_once 'constants.php';


$config['displayErrorDetails']= true;
$config['addContentLengthHeader']= false;

$config['logger']['name']=LOG_NAME;
$config['logger']['path']=LOG_PATH;
$config['logger']['level']=LOG_LEVEL;

$config['redis']['host']=REDIS_HOST;
$config['redis']['port']=REDIS_PORT;
