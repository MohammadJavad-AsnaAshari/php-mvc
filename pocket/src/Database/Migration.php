<?php

namespace Mj\PocketCore\Database;

use Mj\PocketCore\Application;

class Migration
{
    public function __construct(public Database $database)
    {
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();

        $migrationsDir = Application::$ROOT_DIR . "database/migrations";
        $migrations = scandir($migrationsDir);

        foreach ($migrations as $migration) {
            if ($migration === '.' || $migration === "..") {
                continue;
            };

            $migrateInstance = require_once $migrationsDir . DIRECTORY_SEPARATOR . $migration;
            $this->log("applying migration $migration");
            $migrateInstance->up();
            $this->log("applied migration $migration");
        }
    }

    public function rollbackMigrations()
    {
    }

    public function createMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            batch INT NOT NULL
        ) ENGINE=INNODB;";

        $this->database->pdo->exec($sql);
    }

    private function log($message): void
    {
        $time = date('Y-m-d H:i:s');
        echo "[$time] - $message" . PHP_EOL;
    }
}