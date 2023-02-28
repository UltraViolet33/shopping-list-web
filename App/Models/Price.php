<?php

namespace App\Models;

use App\Core\Database\Database;
use stdClass;

class Price extends Model
{


    public function create(array $data): bool
    {
        return true;
    }

    public function update(array $data): bool
    {
        return true;
    }

    public function selectAll(): array
    {
        return [];
    }

    public function selectOneById(int $id): object
    {
        return new stdClass();
    }

    public function delete(int $id): bool
    {
        $query  = "DELETE FROM $this->table WHERE id_price = :id_price";
        return $this->db->write($query, ["id_price" => $id]);
    }
}
