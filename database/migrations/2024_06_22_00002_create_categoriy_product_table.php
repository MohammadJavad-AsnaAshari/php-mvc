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
        $sql = "CREATE TABLE IF NOT EXISTS `category_product` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `category_id` INT NOT NULL,
              `product_id` INT NOT NULL,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              CONSTRAINT `fk_category_product_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
              CONSTRAINT `fk_category_product_product_id` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
        );";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `category_product`";

        $this->pdo->exec($sql);
    }
};
