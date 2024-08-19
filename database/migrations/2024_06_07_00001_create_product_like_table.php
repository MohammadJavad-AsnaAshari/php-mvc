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
        $sql = "CREATE TABLE IF NOT EXISTS `product_like` (
              `product_id` INT NOT NULL,
              `user_id` INT NOT NULL,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`product_id`, `user_id`),
              CONSTRAINT `fk_product_like_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_product_like_product_id` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
        );";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `product_like`";

        $this->pdo->exec($sql);
    }
};
