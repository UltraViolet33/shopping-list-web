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


    public function selectPriceFromProductAndStore(array $data): object|bool
    {
        $query = "SELECT id_price, amount FROM prices WHERE id_store = :id_store AND id_product = :id_product";
        return $this->db->readOneRow($query, $data);
    }

        // public function selectPriceByStoreAndProduct(array $data): bool|object
    // {
    //     $query = "SELECT amount FROM prices WHERE id_products = :id_products AND id_store = :id_store";
    //     return $this->db->readOneRow($query, $data);
    // }
}
