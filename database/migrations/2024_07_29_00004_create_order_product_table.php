<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `order_product` (
              `order_id` INT NOT NULL,
              `product_id` INT NOT NULL,
              `quantity` INT DEFAULT 1,
              CONSTRAINT `fk_order_product_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`),
              CONSTRAINT `fk_order_product_product_id` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
        );";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `order_product`";

        $this->database->pdo->exec($sql);
    }
};
