<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    private PDO $pdo;

    public function __construct() {
        $this->database = Database::getInstance();
        $this->pdo = $this->database->getPDO();
    }

    public function up(): void
    {
        $sql = "ALTER TABLE users MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE users MODIFY created_at TIMESTAMP NULL";

        $this->pdo->exec($sql);
    }
};