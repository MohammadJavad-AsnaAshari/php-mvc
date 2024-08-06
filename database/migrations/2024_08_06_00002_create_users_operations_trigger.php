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
        $sql = "CREATE TRIGGER `users_insert_trigger`
            AFTER INSERT ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (`table_name`, `action`, `data_id`, `new_data`)
                VALUES ('users', 'INSERT', NEW.id, JSON_OBJECT('id', NEW.id, 'name', NEW.name, 'email', NEW.email));
            END;";

        $this->pdo->exec($sql);

        // Create the trigger for update operations
        $sql = "CREATE TRIGGER `users_update_trigger`
            AFTER UPDATE ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (`table_name`, `action`, `data_id`, `old_data`, `new_data`)
                VALUES ('users', 'UPDATE', NEW.id, JSON_OBJECT('id', OLD.id, 'name', OLD.name, 'email', OLD.email), JSON_OBJECT('id', NEW.id, 'name', NEW.name, 'email', NEW.email));
            END;";

        $this->pdo->exec($sql);

        // Create the trigger for delete operations
        $sql = "CREATE TRIGGER `users_delete_trigger`
            AFTER DELETE ON `users`
            FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (`table_name`, `action`, `data_id`, `old_data`)
                VALUES ('users', 'DELETE', OLD.id, JSON_OBJECT('id', OLD.id, 'name', OLD.name, 'email', OLD.email));
            END;";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        // Drop the triggers
        $sql = "DROP TRIGGER IF EXISTS `users_insert_trigger`";
        $this->pdo->exec($sql);

        $sql = "DROP TRIGGER IF EXISTS `users_update_trigger`";
        $this->pdo->exec($sql);

        $sql = "DROP TRIGGER IF EXISTS `users_delete_trigger`";
        $this->pdo->exec($sql);
    }
};
