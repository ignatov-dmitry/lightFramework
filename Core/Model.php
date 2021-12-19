<?php


namespace Core;


use Exception;
use stdClass;

abstract class Model
{
    protected $query;

    protected $table;

    protected function reset()
    {
        $this->query = new stdClass();
    }

    public function select(array $fields): Model
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . "FROM " . $this->table;

        return $this;
    }

    public function where(string $field, string $operator, string $value): Model
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset): Model
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";
        return $sql;
    }

    public function get()
    {

    }
}