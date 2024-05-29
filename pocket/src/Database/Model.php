<?php

namespace Mj\PocketCore\Database;

use Mj\PocketCore\Database\Trait\Relation;
use PDOStatement;

class Model extends Database
{
    use Relation;
    protected string $table;
    protected string $sql;
    protected PDOStatement $statement;
    protected string $selectedItems = '*';
    protected array $whereItems = [];
    protected array $valuesForBind = [];
    protected ?int $limit = null;

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $dataKeys = array_keys($data);
        $fields = implode(', ', $dataKeys);
        $params = implode(', ', array_map(fn($key) => ":$key", $dataKeys));

        $this->sql = "INSERT INTO $this->table ($fields) VALUES ($params)";
        $this->statement = $this->pdo->prepare($this->sql);
        foreach ($data as $key => $value) {
            $this->statement->bindValue(":$key", $value);
        }

        return $this->statement->execute();
    }

    /**
     * @return bool|array
     */
    public function get(): bool|array
    {
        //return $this->result()->statement->fetchAll(\PDO::FETCH_OBJ);

        $results = $this->result()->statement->fetchAll(\PDO::FETCH_ASSOC);
        $objects = [];
        foreach ($results as $row) {
            $object = new static();
            $object->setProperties($row);
            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        //return $this->limit(1)->result()->statement->fetch(\PDO::FETCH_OBJ);

        $result = $this->limit(1)->result()->statement->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            $object = new static();
            $object->setProperties($result);
            return $object;
        }

        return null;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        // Add 'updated_at' field to the data array with the current timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');

        $dataKeys = array_keys($data);
        $fields = implode(', ', array_map(fn($key) => "$key = :$key", $dataKeys));

        $this->sql = "UPDATE $this->table SET $fields WHERE id = :id";
        $this->statement = $this->pdo->prepare($this->sql);
        $this->statement->bindValue(':id', $id);
        foreach ($data as $key => $value) {
            $this->statement->bindValue(":$key", $value);
        }

        return $this->statement->execute();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $this->sql = "DELETE FROM $this->table WHERE id = :id";
        $this->statement = $this->pdo->prepare($this->sql);
        $this->statement->bindValue(':id', $id);

        return $this->statement->execute();
    }

    /**
     * @return $this
     */
    public function result(): self
    {
        $this->sql = "SELECT $this->selectedItems FROM $this->table";
        $this->appendWhereClause()->appendLimitClause();
        $this->prepareAndBind();
        $this->statement->execute();

        return $this;
    }

    /**
     * @return $this
     */
    public function select(): self
    {
        $this->selectedItems = implode(', ', func_get_args());

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string $column
     * @param string|int|bool $value
     * @param string $operator
     * @return $this
     */
    public function where(string $column, string|int|bool $value, string $operator = "="): self
    {
        if ($operator === 'LIKE') {
            $value = '%' . $value . '%';
        }

        $this->whereItems[] = "$column $operator :$column";
        $this->valuesForBind[$column] = $value;

        return $this;
    }

    /**
     * @param string|int|bool $value
     * @param string $column
     * @return mixed
     */
    public function find(string|int|bool $value, string $column = 'id')
    {
        return $this->where($column, $value)->first();
    }

    public function from(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return self
     */
    private function appendWhereClause(): self
    {
        if (!empty($this->whereItems)) {
            $this->sql .= " WHERE " . implode(' AND ', $this->whereItems);
        }

        return $this;
    }

    /**
     * @return self
     */
    private function appendLimitClause(): self
    {
        if (isset($this->limit)) {
            $this->sql .= " LIMIT $this->limit";
        }

        return $this;
    }

    /**
     * @return void
     */
    private function prepareAndBind(): void
    {
        $this->statement = $this->pdo->prepare($this->sql);
        foreach ($this->valuesForBind as $column => $value) {
            $this->statement->bindValue(":$column", $value);
        }
    }

    protected function setProperties(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->$key = $value;
        }
    }
}