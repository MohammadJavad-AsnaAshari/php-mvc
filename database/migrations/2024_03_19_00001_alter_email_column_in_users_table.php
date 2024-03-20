<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "ALTER TABLE users ADD CONSTRAINT email_unique UNIQUE (email)";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE users DROP CONSTRAINT unique_email";

        $this->database->pdo->exec($sql);
    }
};