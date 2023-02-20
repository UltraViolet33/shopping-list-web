<?php

namespace App\Models;

use App\Core\Database\Database;

abstract class Model
{
    protected  Database $db;
    protected string $table;


    public function __construct()
    {
        $this->db = Database::getInstance();
        // $this->table = get_class($this);
        $this->table = $this->getTableName();
    }


    private function getTableName(): string
    {
        $table = get_class($this);
        $table = strtolower(explode("\\", get_class($this))[2] . 's');
        return $table;
    }

    abstract protected function create(array $data): bool;

    abstract protected function update(array $data): bool;

    abstract protected function selectAll(): array;

    abstract protected function selectOneById(int $id): object;

    abstract protected function delete(int $id): bool;
}
