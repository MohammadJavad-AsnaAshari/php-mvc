<?php

namespace Mj\PocketCore\Database;

class Model extends Database
{
    protected string $table;
    protected \PDOStatement $statement;
    protected string $selectedItems = '*';

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
        $this->statement = $this->pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $this->statement->bindValue(":$key", $value);
        }

        return $this->statement->execute();
    }

    public function get(): bool|array
    {
        return $this->result()->statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function first()
    {
        return $this->result()->statement->fetch(\PDO::FETCH_OBJ);
    }

    public function update(int $id, array $data): bool
    {
        // Add 'updated_at' field to the data array with the current timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');

        $dataKeys = array_keys($data);
        $fields = implode(', ', array_map(fn($key) => "$key = :$key", $dataKeys));

        $sql = "UPDATE $this->table SET $fields WHERE id = :id";
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->bindValue(':id', $id);
        foreach ($data as $key => $value) {
            $this->statement->bindValue(":$key", $value);
        }

        return $this->statement->execute();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->bindValue(':id', $id);

        return $this->statement->execute();
    }

    public function result(): self
    {
        $sql = "SELECT $this->selectedItems FROM $this->table";
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->execute();

        return $this;
    }

    public function select(): self
    {
        $this->selectedItems = implode(', ', func_get_args());

        return $this;
    }
}