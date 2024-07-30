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
    protected string $orderBy;

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

        if ($this->statement->execute()) {
            // Get the last inserted ID and set it to the object
            $this->id = $this->pdo->lastInsertId();
            // Set other properties from the data array
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
            return true;
        }

        return false;
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
        $this->appendWhereClause()->appendOrderByClause()->appendLimitClause();
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

    public function query(string $sql, array $values = []): array
    {
        $this->statement = $this->pdo->prepare($sql);
        foreach ($values as $key => $value) {
            $this->statement->bindValue(":$key", $value);
        }
        $this->statement->execute();

        $results = $this->statement->fetchAll(\PDO::FETCH_ASSOC);
        $objects = [];
        foreach ($results as $row) {
            $object = new static();
            $object->setProperties($row);
            $objects[] = $object;
        }

        return $objects;
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

    public function whereIn(string $column, array $values): self
    {
        $placeholders = implode(', ', array_map(fn($value) => ":{$column}_{$value}", $values));
        $this->whereItems[] = "$column IN ($placeholders)";
        foreach ($values as $value) {
            $this->valuesForBind["{$column}_{$value}"] = $value;
        }

        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy = "$column $direction";

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

    public function pluck(string $column = 'id')
    {
        $results = $this->get();
        $pluckedResults = [];

        foreach ($results as $result) {
            $pluckedResults[] = $result->$column;
        }

        return $pluckedResults;
    }

    public function from(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function count(): int
    {
        $this->selectedItems = 'COUNT(*) as total';
        $this->result();
        $count = $this->statement->fetchColumn();

        return (int)$count;
    }

    public function exists(): bool
    {
        $this->limit(1);
        $this->result();

        return $this->statement->rowCount() > 0;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @param string $operator
     * @return $this
     */
    public function leftJoin(string $table, string $firstColumn, string $secondColumn, string $operator = '='): self
    {
        $this->sql .= " LEFT JOIN $table ON $firstColumn $operator $secondColumn";

        return $this;
    }

    /**
     * @param string $table
     * @param string $firstColumn
     * @param string $secondColumn
     * @param string $operator
     * @return $this
     */
    public function rightJoin(string $table, string $firstColumn, string $secondColumn, string $operator = '='): self
    {
        $this->sql .= " RIGHT JOIN $table ON $firstColumn $operator $secondColumn";

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

    private function appendOrderByClause(): self
    {
        if (!empty($this->orderBy)) {
            $this->sql .= " ORDER BY $this->orderBy";
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