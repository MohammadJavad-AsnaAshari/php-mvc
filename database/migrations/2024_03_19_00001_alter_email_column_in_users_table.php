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
        $sql = "ALTER TABLE users ADD CONSTRAINT email_unique UNIQUE (email)";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE users DROP CONSTRAINT email_unique";

        $this->pdo->exec($sql);
    }
};