<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `permission_role` (
              `permission_id` INT NOT NULL,
              `role_id` INT NOT NULL,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`permission_id`, `role_id`),
              CONSTRAINT `fk_permission_role_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`),
              CONSTRAINT `fk_permission_role_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`)
        );";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `permission_role`";

        $this->database->pdo->exec($sql);
    }
};
