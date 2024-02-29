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
        $sql = "ALTER TABLE users ADD COLUMN password VARCHAR(255) NOT NULL AFTER email";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE users DROP COLUMN password";

        $this->database->pdo->exec($sql);
    }
};