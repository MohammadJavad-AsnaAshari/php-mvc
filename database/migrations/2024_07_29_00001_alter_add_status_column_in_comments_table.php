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
        $sql = "ALTER TABLE `comments`
                ADD COLUMN `status` BOOLEAN NOT NULL DEFAULT 0 AFTER `comment`;";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE `comments`
                DROP COLUMN `status`;";

        $this->pdo->exec($sql);
    }
};
