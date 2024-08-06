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
        $sql = "CREATE TABLE IF NOT EXISTS `logs` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `table_name` VARCHAR(255) NOT NULL,
            `action` VARCHAR(255) NOT NULL,
            `data_id` INT,
            `old_data` TEXT,
            `new_data` TEXT,
            `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `logs`";

        $this->pdo->exec($sql);
    }
};
