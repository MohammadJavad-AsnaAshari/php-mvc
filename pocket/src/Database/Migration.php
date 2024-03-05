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
        $appliedMigrations = array_map(fn($migration) => $migration->migration . '.php', $this->getAppliedMigrations());

        $migrationsDir = Application::$ROOT_DIR . "database/migrations";
        $files = scandir($migrationsDir);

        $newMigrations = [];

        $migrations = array_diff($files, $appliedMigrations);
        foreach ($migrations as $migration) {
            if ($migration === '.' || $migration === "..") {
                continue;
            };

            $migrateInstance = require_once $migrationsDir . DIRECTORY_SEPARATOR . $migration;
            $newMigrations[] = $migration;

            $this->log("applying migration $migration");
            $migrateInstance->up();
            $this->log("applied migration $migration");
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log('there is no migration to apply!');
        }
    }

    public function rollbackMigrations()
    {
        $migrationsDir = Application::$ROOT_DIR . "database/migrations";
        $appliedMigrations = array_reverse($this->getAppliedMigrations());
        $lastBatch = $this->getLastBatchNumber();
        $mustRollbackMigrations = array_filter($appliedMigrations, fn($migration) => $migration->batch === $lastBatch);

        foreach ($mustRollbackMigrations as $migration) {
            $migrateInstance = require_once $migrationsDir . DIRECTORY_SEPARATOR . $migration->migration . '.php';

            $this->log("rolling back migration {$migration->migration}");
            $migrateInstance->down();
            $this->log("rolled back migration {$migration->migration}");
        }

        if (!empty($mustRollbackMigrations)) {
            $deleteMigrations = array_map(fn($migration) => $migration->id, $mustRollbackMigrations);
            $this->deleteMigrations($deleteMigrations);
        } else {
            $this->log('there is no migration to rollback!');
        }
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

    private function saveMigrations($newMigrations)
    {
        $batchNumber = $this->getLastBatchNumber() + 1;

        $rows = array_map(fn($migration) => str_replace('.php', '', $migration), $newMigrations);
        $migrations = implode(', ', array_map(fn($migration) => "('$migration', '$batchNumber')", $rows));

        $sql = "INSERT INTO migrations (migration, batch) VALUES $migrations";
        $statement = $this->database->pdo->prepare($sql);
        $statement->execute();
    }

    private function getLastBatchNumber(): int
    {
        $sql = "SELECT MAX(batch) AS MAX FROM migrations";
        $statement = $this->database->pdo->query($sql);

        return $statement->fetchColumn() ?? 0;
    }

    private function getAppliedMigrations(): ?array
    {
        $sql = "SELECT * FROM migrations";
        $statement = $this->database->pdo->query($sql);

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    private function deleteMigrations(array $migration): void
    {
        $migrationsId = implode(', ', $migration);
        $sql = "DELETE FROM migrations WHERE id IN ($migrationsId)";
        $statement = $this->database->pdo->prepare($sql);
        $statement->execute();
    }
}