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
        $sql = "ALTER TABLE users ADD COLUMN password VARCHAR(255) NOT NULL AFTER email";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE users DROP COLUMN password";

        $this->pdo->exec($sql);
    }
};