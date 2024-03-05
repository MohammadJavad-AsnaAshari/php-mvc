<?php

use Mj\PocketCore\Application;

$root = dirname(__DIR__).DIRECTORY_SEPARATOR;

define('VENDOR_PATH', $root.'vendor'.DIRECTORY_SEPARATOR);

require_once VENDOR_PATH."autoload.php";

$app = new Application($root);

/*
 * You have to run `php database/migration` in your command line to apply migrations.
 * You have to run `php database/migration --rollback` in your command line to rollback migrations.
 */

match ($argv[1] ?? false) {
    '--rollback' => $app->database->migration->rollbackMigrations(),
    default => $app->database->migration->applyMigrations()
};

