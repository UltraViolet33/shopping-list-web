<?php

namespace App\Models;

use App\Core\Database\Database;

class Model
{
    protected  Database $db;
    protected string $table;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = get_class($this);
        $this->table = $this->getTableName();
    }

    /**
     * getTableName
     *
     * @return string
     */
    private function getTableName(): string
    {
        $table = get_class($this);
        $table = strtolower(explode("\\", get_class($this))[2] . 's');
        return $table;
    }
}
