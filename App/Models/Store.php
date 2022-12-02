<?php

namespace App\Models;

use App\Core\Database\Database;

class Store extends Model
{

    /**
     * create
     *
     * @param  array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $query = "INSERT INTO $this->table(name) VALUES(:name)";
        return Database::getInstance()->write($query, $data);
    }
}
