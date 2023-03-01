<?php

namespace App\Models;

class Price extends Model
{

    public function create(array $data): bool
    {
        $query = "INSERT INTO $this->table(amount, id_product, id_store) VALUES(:amount, :id_product, :id_store)";
        return $this->db->write($query, $data);
    }


    public function update(array $data): bool
    {
        return true;
    }
}
