<?php

namespace App\Models;

use App\Core\Database\Database;

class Store extends Model
{


    public function create(array $data): bool
    {
        $query = "INSERT INTO $this->table(name) VALUES(:name)";
        return $this->db->write($query, $data);
    }


    public function selectAll(): array
    {
        $query = "SELECT * FROM $this->table";
        return $this->db->read($query);
    }


    public function selectOneById(int $id): object
    {
        $query = "SELECT * FROM $this->table WHERE id_store = :id_store";
        return $this->db->readOneRow($query, ["id_store" => $id]);
    }


    public function update(array $data): bool
    {
        $query = "UPDATE stores SET name = :name WHERE id_store = :id_store";
        return $this->db->write($query, $data);
    }

    /**
     * selectStoresByProducts
     *
     * @param int $id
     * @return array|bool
     */
    public function selectStoresByProducts(int $id): array|bool
    {
        $query = "SELECT $this->table.name FROM $this->table 
        INNER JOIN products_stores ON $this->table.id_stores = products_stores.id_stores 
        WHERE products_stores.id_products = :id_products";

        return $this->db->read($query, ["id_products" => $id]);
    }


    public function delete(int $id): bool
    {
        $query = "DELETE FROM $this->table WHERE id_store = :id_store";
        return $this->db->write($query, ["id_store" => $id]);
    }
}
