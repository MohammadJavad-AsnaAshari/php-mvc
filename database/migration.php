<?php

use Mj\PocketCore\Application;

$root = dirname(__DIR__).DIRECTORY_SEPARATOR;

define('VENDOR_PATH', $root.'vendor'.DIRECTORY_SEPARATOR);

require_once VENDOR_PATH."autoload.php";

$app = new Application($root);

/*
 * You have to run `php database/migration` in you command line to apply migrations.
 */
$app->database->migration->applyMigrations();
