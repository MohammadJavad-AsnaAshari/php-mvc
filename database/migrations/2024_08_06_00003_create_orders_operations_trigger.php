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
        // Create the trigger for insert operations
        $sql = "CREATE TRIGGER `orders_insert_trigger`
            AFTER INSERT ON `orders`
            FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (`table_name`, `action`, `data_id`, `new_data`)
                VALUES ('orders', 'INSERT', NEW.id, JSON_OBJECT('id', NEW.id, 'user_id', NEW.user_id, 'price', NEW.price, 'status', NEW.status));
            END;";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        // Drop the triggers
        $sql = "DROP TRIGGER IF EXISTS `orders_insert_trigger`";
        $this->pdo->exec($sql);
    }
};
