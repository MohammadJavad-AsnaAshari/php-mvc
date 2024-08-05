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
        $sql = "ALTER TABLE `products` ADD COLUMN `image` VARCHAR(255) NOT NULL AFTER `specification`";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE `products` DROP COLUMN `image`";

        $this->pdo->exec($sql);
    }
};