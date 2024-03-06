<?php

use Mj\PocketCore\Database\Database;

return new class {

    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "ALTER TABLE users ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL AFTER created_at";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE users DROP COLUMN updated_at";

        $this->database->pdo->exec($sql);
    }
};