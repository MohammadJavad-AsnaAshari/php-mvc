<?php

use Mj\PocketCore\Database\Database;

return new class {

    private Database $database;
    private PDO $pdo;

    public function __construct() {
        $this->database = Database::getInstance();
        $this->pdo = $this->database->getPDO();
    }

    public function up(): void
    {
        $sql = "ALTER TABLE users ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER created_at";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE users DROP COLUMN updated_at";

        $this->pdo->exec($sql);
    }
};