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

    public function update(int $id, array $data): bool
    {
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
}