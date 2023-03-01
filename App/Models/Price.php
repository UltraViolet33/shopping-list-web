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
        $query = "UPDATE $this->table SET amount = :amount WHERE id_store = :id_store AND id_product = :id_product";
        return $this->db->write($query, $data);
    }
}
