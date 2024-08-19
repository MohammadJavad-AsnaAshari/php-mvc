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
        $sql = "CREATE VIEW product_index AS
                SELECT products.*, GROUP_CONCAT(DISTINCT categories.name) as categories, COUNT(DISTINCT CONCAT(product_like.product_id, product_like.user_id)) as likes
                FROM products
                LEFT JOIN product_like ON products.id = product_like.product_id
                LEFT JOIN category_product ON products.id = category_product.product_id
                LEFT JOIN categories ON category_product.category_id = categories.id
                GROUP BY products.id";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP VIEW product_index";

        $this->pdo->exec($sql);
    }
};
