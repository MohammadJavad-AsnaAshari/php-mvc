<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `categories` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `name` VARCHAR(255) NOT NULL UNIQUE,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        );";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `categories`";

        $this->database->pdo->exec($sql);
    }
};
