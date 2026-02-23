<?php

namespace Source\Core;

use PDO;
use PDOStatement;
use Source\Core\Message;

abstract class Model
{
    protected ?object $data = null;
    protected ?\PDOException $fail = null;
    protected Message $message;

    protected string $query;

    protected array $params;

    protected string $order;

    protected int $limit;

    protected int $offset;

    public function __construct()
    {
        $this->message = new Message();
    }

    public function getData(): ?object
    {
        return $this->data;
    }

    public function getFail(): ?\PDOException
    {
        return $this->fail;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function find(?string $terms = null, ?string $params = null, string $columns = "*"): null|Model
    {
        if ($terms) {
            $this->query = "SELECT {$columns} FROM " . static::$entity . " WHERE {$terms}";
            parse_str($params, $this->params);
            return $this;
        }

        $this->query = "SELECT {$columns} FROM " . static::$entity;
        return $this;
    }

    public function order(string $columnOrder): Model
    {
        $this->order = " ORDER BY {$columnOrder}";
    }

    public function limit(int $limit): Model
    {
        $this->limit = " LIMIT {$limit}";
    }

    public function offset(int $offset): Model
    {
        $this->offset = " OFFSET {$offset}";
    }

    public function fetch(bool $all = false)
    {
        try {
            $statement = Connect::getInstance()->prepare($this->query . $this->order . $this->limit . $this->offset);
            $statement->execute($this->params);

            if (!$statement->rowCount()) {
                return null;
            }

            if ($all) {
                return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
            }

            return $statement->fetchObject(static::class);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    public function count(string $key = "id"): int
    {
        $statement = Connect::getInstance()->prepare($this->query);
        $statement->execute($this->params);

        return $statement->rowCount();
    }

    protected function create(array $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $statement = Connect::getInstance()->prepare(
                "INSERT INTO " . static::$entity . " ({$columns}) VALUES ({$values})"
            );

            foreach ($data as $key => $value) {
                $statement->bindValue(":{$key}", $value);
            }

            $statement->execute();

            return Connect::getInstance()->lastInsertId();
        } catch (\PDOException $e) {
            $this->fail = $e;
            return null;
        }
    }

    protected function read(string $query, ?string $params = null): ?PDOStatement
    {
        try {
            $statement = Connect::getInstance()->prepare($query);

            if ($params) {
                parse_str($params, $params);
                foreach ($params as $key => $value) {
                    if ($key == "limit" || $key == "offset") {
                        $statement->bindValue(":$key", $value, \PDO::PARAM_INT);
                    } else {
                        $statement->bindValue(":$key", $value, \PDO::PARAM_STR);
                    }
                }
            }

            $statement->execute();
            return $statement;
        } catch (\PDOException $PDOException) {
            $this->fail = $PDOException;
            return null;
        }
    }

    protected function update(array $data, string $terms, string $params): bool
    {
        try {
            $set = [];

            foreach (array_keys($data) as $column) {
                $set[] = "{$column} = :{$column}";
            }

            $set = implode(", ", $set);

            $statement = Connect::getInstance()->prepare(
                "UPDATE " . static::$entity . " SET {$set} WHERE {$terms}"
            );

            foreach ($data as $key => $value) {
                if ($key == "limit" || $key == "offset") {
                    $statement->bindValue(":$key", $value, \PDO::PARAM_INT);
                } else {
                    $statement->bindValue(":$key", $value, \PDO::PARAM_STR);
                }
            }

            parse_str($params, $params);

            foreach ($params as $key => $value) {
                $type = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $statement->bindValue(":{$key}", $value, $type);
            }

            return $statement->execute();
        } catch (\PDOException $e) {
            $this->fail = $e;
            return false;
        }
    }

    protected function delete(string $key, string $value): bool
    {
        try {
            $statement = Connect::getInstance()->prepare(
                "DELETE FROM " . static::$entity . " WHERE {$key} = :key"
            );

            $statement->bindValue(":key", $value, \PDO::PARAM_STR);

            $statement->execute();

            return true;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    protected function safe(): ?array
    {
        $safe = (array)$this->data;

        foreach (static::$safe as $unset) {
            unset($safe[$unset]);
        }
        return $safe;
    }

    protected function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }

        return $filter;
    }

    protected function required(): bool
    {
        $data = (array)$this->data();

        foreach (static::$required as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }

        return true;
    }

    protected function hydrate(array $data): static
    {
        $model = new static();

        foreach ($data as $column => $value) {
            $method = 'set' . str_replace('_', '', ucwords($column, '_'));

            if (method_exists($model, $method)) {
                $model->$method($value);
            }
        }

        return $model;
    }

    abstract protected function data();
}