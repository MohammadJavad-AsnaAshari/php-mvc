<?php

namespace Mj\PocketCore\Database;

class Model extends Database
{
    protected string $table;

    public function __construct()
    {
        parent::__construct();
    }

    public function create(array $data): bool
    {
        $dataKeys = array_keys($data);
        $fields = implode(', ', $dataKeys);
        $params = implode(', ', array_map(fn($key) => ":$key", $dataKeys));

        $sql = "INSERT INTO $this->table ($fields) VALUES ($params)";
        $statement = $this->pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        return $statement->execute();
    }

    public function get(): bool|array
    {
        $sql = "SELECT * FROM $this->table";
        $query = $this->pdo->query($sql);

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function first()
    {
        $sql = "SELECT * FROM $this->table";
        $query = $this->pdo->query($sql);

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    public function update(int $id, array $data): bool
    {
        // Add 'updated_at' field to the data array with the current timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');

        $dataKeys = array_keys($data);
        $fields = implode(', ', array_map(fn($key) => "$key = :$key", $dataKeys));

        $sql = "UPDATE $this->table SET $fields WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        return $statement->execute();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);

        return $statement->execute();
    }
}