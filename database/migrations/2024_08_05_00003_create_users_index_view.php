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
        $sql = "CREATE VIEW user_index AS
                SELECT users.*, GROUP_CONCAT(permissions.name) as permissions
                FROM users
                LEFT JOIN permission_user ON users.id = permission_user.user_id
                LEFT JOIN permissions ON permission_user.permission_id = permissions.id
                GROUP BY users.id";

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP VIEW user_index";

        $this->pdo->exec($sql);
    }
};
