<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "ALTER TABLE `products` ADD COLUMN `image` VARCHAR(255) NOT NULL AFTER `specification`";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE `products` DROP COLUMN `image`";

        $this->database->pdo->exec($sql);
    }
};