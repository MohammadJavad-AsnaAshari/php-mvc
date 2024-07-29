<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `payments` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `order_id` INT NOT NULL,
              `status` BOOLEAN NOT NULL DEFAULT 0,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              CONSTRAINT `fk_payments_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`)
        );";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `payments`";

        $this->database->pdo->exec($sql);
    }
};
