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
        $sql = "CREATE FUNCTION IF NOT EXISTS calculate_total_price(price INT, quantity INT)
                RETURNS INT
                DETERMINISTIC
                BEGIN
                    RETURN price * quantity;
                END";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP FUNCTION IF EXISTS calculate_total_price";

        $this->pdo->exec($sql);
    }
};
