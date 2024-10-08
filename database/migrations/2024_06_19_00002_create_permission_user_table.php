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
        $sql = "CREATE TABLE IF NOT EXISTS `permission_user` (
              `permission_id` INT NOT NULL,
              `user_id` INT NOT NULL,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`permission_id`, `user_id`),
              CONSTRAINT `fk_permission_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_permission_user_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
        );";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `permission_user`";

        $this->pdo->exec($sql);
    }
};
