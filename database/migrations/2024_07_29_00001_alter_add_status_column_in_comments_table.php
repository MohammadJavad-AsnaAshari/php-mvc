<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "ALTER TABLE `comments`
                ADD COLUMN `status` BOOLEAN NOT NULL DEFAULT 0 AFTER `comment`;";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE `comments`
                DROP COLUMN `status`;";

        $this->database->pdo->exec($sql);
    }
};
