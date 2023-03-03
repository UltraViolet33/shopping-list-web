<?php

namespace App\Models;


class Store extends Model
{

    public function create(array $data): bool
    {
        $query = "INSERT INTO $this->table(name) VALUES(:name)";
        return $this->db->write($query, $data);
    }


    public function update(array $data): bool
    {
        $query = "UPDATE stores SET name = :name WHERE id_store = :id_store";
        return $this->db->write($query, $data);
    }


    public function selectStoresLeftFromProduct(int $idProduct): array
    {
        $productStoresId = $this->getStoresIdFromProduct($idProduct);
        if (count($productStoresId) == 0) {
            return $this->selectAll();
        }
        $query = "SELECT * FROM stores WHERE id_store NOT IN (" . implode(",", $productStoresId) . ")";
        return $this->db->read($query);
    }


    public function getStoresIdFromProduct(int $idProduct): array
    {
        $query = "SELECT id_store FROM prices WHERE id_product = :id_product";
        $result = $this->db->read($query, ["id_product" => $idProduct]);

        $idStores = [];

        foreach ($result as $item) {
            $idStores[] = $item->id_store;
        }

        return $idStores;
    }



    /**
     * selectStoresByProducts
     *
     * @param int $id
     * @return array|bool
     */
    // public function selectStoresByProducts(int $id): array|bool
    // {
    //     $query = "SELECT $this->table.name FROM $this->table 
    //     INNER JOIN products_stores ON $this->table.id_stores = products_stores.id_stores 
    //     WHERE products_stores.id_products = :id_products";

    //     return $this->db->read($query, ["id_products" => $id]);
    // }
}
