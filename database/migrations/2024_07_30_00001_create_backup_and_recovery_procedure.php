<?php

use Mj\PocketCore\Database\Database;

return new class {

    private Database $database;
    private PDO $pdo;

    public function __construct() {
        $this->database = Database::getInstance();
        $this->pdo = $this->database->getPDO();
    }

    public function up(): void
    {
        $dbHost = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_NAME'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];

        $sql = "
        CREATE PROCEDURE backup_database()
        BEGIN
            DECLARE backup_file VARCHAR(255);
            SET backup_file = CONCAT('/tmp/', DATE_FORMAT(NOW(), '%Y-%m-%d_%H-%i-%s'), '.sql');
            SET @cmd = CONCAT('mysqldump --user=', '$dbUsername', ' --password=', '$dbPassword', ' --host=', '$dbHost', ' ', '$dbName', ' > ', backup_file);
            SELECT @cmd AS command;
        END;

        CREATE PROCEDURE restore_database(IN backup_file VARCHAR(255))
        BEGIN
            SET @cmd = CONCAT('mysql --user=', '$dbUsername', ' --password=', '$dbPassword', ' --host=', '$dbHost', ' ', '$dbName', ' < ', backup_file);
            SELECT @cmd AS command;
        END;
    ";

        // Replace placeholders with actual values
        $sql = str_replace(['$dbUsername', '$dbPassword', '$dbHost', '$dbName'], [$dbUsername, $dbPassword, $dbHost, $dbName], $sql);

        $this->pdo->exec($sql);
    }

    public function down(): void
    {
        $sql = "
            DROP PROCEDURE IF EXISTS backup_database;
            DROP PROCEDURE IF EXISTS restore_database;
        ";

        $this->pdo->exec($sql);
    }
};
