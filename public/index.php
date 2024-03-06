<?php

use Mj\PocketCore\Application;

date_default_timezone_set("Asia/Tehran");
$root = dirname(__DIR__).DIRECTORY_SEPARATOR;

define('APP_PATH', $root.'app'.DIRECTORY_SEPARATOR);
define('VENDOR_PATH', $root.'vendor'.DIRECTORY_SEPARATOR);

require_once VENDOR_PATH."autoload.php";

$app = new Application($root);

$app->router
    ->setRouterFile($root . 'routes' . DIRECTORY_SEPARATOR . 'web.php')
    ->setRouterFile($root . 'routes' . DIRECTORY_SEPARATOR . 'api.php');

$app->run();