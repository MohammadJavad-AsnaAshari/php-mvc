<?php

use Mj\PocketCore\Database\Database;

return new class {

    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function up(): void
    {
        $sql = "ALTER TABLE articles ADD COLUMN user_id INT AFTER id";
        $this->database->pdo->exec($sql);

        $sql = "ALTER TABLE articles ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE";
        $this->database->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE articles DROP CONSTRAINT fk_users_id";
        $this->database->pdo->exec($sql);

        $sql = "ALTER TABLE articles DROP COLUMN user_id";
        $this->database->pdo->exec($sql);
    }
};