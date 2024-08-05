<?php

use Mj\PocketCore\Database\Database;

return new class {

    private Database $database;
    private PDO $pdo;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->pdo = $this->database->getPDO();
    }

    public function up(): void
    {
        $sql = "CREATE VIEW comment_index AS
                SELECT comments.*, users.name as user_name, products.name as product_name
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                INNER JOIN products ON comments.product_id = products.id
                ORDER BY comments.created_at DESC";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP VIEW comment_index";

        $this->pdo->exec($sql);
    }
};
