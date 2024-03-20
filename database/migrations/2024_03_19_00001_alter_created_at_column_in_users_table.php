<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "ALTER TABLE users MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE users MODIFY created_at TIMESTAMP NULL";

        $this->database->pdo->exec($sql);
    }
};