<?php

use Mj\PocketCore\Database\Database;

return new class{

    private Database $database;
    public function __construct() {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `role_user` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `role_id` INT NOT NULL,
              `user_id` INT NOT NULL,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              CONSTRAINT `fk_role_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
              CONSTRAINT `fk_role_user_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`)
        );";

        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS `role_user`";

        $this->database->pdo->exec($sql);
    }
};
