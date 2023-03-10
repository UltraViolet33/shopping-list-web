<?php

namespace App\Models;

use App\Models\Model;

class Product extends Model
{

    public function create(array $data): bool
    {
        $query = "INSERT INTO products(name, stock_min, stock_actual, recurrent) 
        VALUES(:name, :stock_min, :stock_actual, :recurrent)";
        return $this->db->write($query, $data);
    }


    public function update(array $data): bool
    {
        $query = "UPDATE products SET name = :name, stock_min = :stock_min, stock_actual = :stock_actual, recurrent = :recurrent
        WHERE id_product = :id_product";
        return $this->db->write($query, $data);
    }


    public function updateStock(array $data): bool
    {
        $query = "UPDATE $this->table SET stock_actual = :stock WHERE $this->id = :id";
        return $this->db->write($query, $data);
    }


    public function selectListProducts(): array
    {
        $query = "SELECT * , (stock_min - stock_actual + 1) AS number_item FROM $this->table WHERE stock_actual <= stock_min";
        return $this->db->read($query);
    }


    public function selectAllRecurrentProducts(): array
    {
        $query = "SELECT * FROM $this->table WHERE recurrent = 1";
        return $this->db->read($query);
    }


    public function selectStoresAndPrice(int $id): array
    {
        $query = "SELECT prices.amount, prices.id_price, stores.name, stores.id_store FROM prices 
        INNER JOIN stores ON stores.id_store = prices.id_store WHERE prices.id_product = :id_product";
        return $this->db->read($query, ["id_product" => $id]);
    }


    public function getAllStoresProduct(int $id): array
    {
        $query = "SELECT id_store FROM prices WHERE id_product = :id_product";
        return $this->db->read($query, ["id_product" => $id]);
    }


    public function getAllStoresFromProduct(int $id): array
    {
        $query = "SELECT prices.id_store, stores.name  FROM prices 
        INNER JOIN stores ON stores.id_store = prices.id_store WHERE prices.id_product = :id_product";
        return $this->db->read($query, ["id_product" => $id]);
    }
}
