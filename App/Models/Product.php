<?php

namespace App\Models;

use App\Core\Database\Database;

class Product extends Model
{

    public function create(array $data): bool
    {
        $query = "INSERT INTO products(name, stock_min, stock_actual, recurrent) 
        VALUES(:name, :stock_min, :stock_actual, :recurent)";
        return $this->db->write($query, $data);
    }



    public function update(array $data): bool
    {
        $query = "UPDATE products SET name = :name, stock_min = :stock_min, stock_actual = :stock_actual, recurrent = :recurrent
        WHERE id_product = :id_product";
        return $this->db->write($query, $data);
    }



    public function selectAll(): array
    {
        $query = "SELECT * FROM $this->table ORDER BY recurrent";
        return $this->db->read($query);
    }


    /**
     * updateStock
     *
     * @param  mixed $id
     * @param  mixed $stock
     * @return bool
     */
    public function updateStock(int $id, int $stock): bool
    {
        $query = "UPDATE products SET stock_actual = :stock WHERE id_product = :id";
        $data['id'] = $id;
        $data['stock'] = $stock;

        return $this->db->write($query, $data);
    }


    /**
     * selectListProducts
     *
     * @return array
     */
    public function selectListProducts(): array
    {
        $query = "SELECT * , (stock_min - stock_actual + 1) AS number_item FROM $this->table WHERE stock_actual <= stock_min";
        return $this->db->read($query);
    }


    // public function getSingleProduct(int $id): object
    // {
    //     $query = "SELECT * FROM $this->table WHERE id_product = :id_product";
    //     return $this->db->readOneRow($query, ['id_product' => $id]);
    // }

    

    public function delete(int $id): bool
    {
        $query = "DELETE FROM $this->table WHERE id_product = :id_product";
        return $this->db->write($query, ['id_product' => $id]);
    }


    public function selectOneById(int $id): object
    {
        $query = "SELECT * FROM $this->table WHERE id_product = :id_product";
        return $this->db->readOneRow($query, ['id_product' => $id]);
    }


    public function addStoreToProduct(array $data): bool
    {
        $query = "INSERT INTO prices(amount, id_product, id_store) VALUES(:amount, :id_product, :id_store)";
        return $this->db->write($query, $data);
    }


    public function selectStoresAndPrice(int $id): array
    {
        $query = "SELECT prices.amount, stores.name, stores.id_store FROM prices 
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

    /**
     * selectPriceByStoreAndProduct
     *
     * @param array $data
     * @return bool|object
     */
    public function selectPriceByStoreAndProduct(array $data): bool|object
    {
        $query = "SELECT amount FROM prices WHERE id_products = :id_products AND id_store = :id_store";
        return $this->db->readOneRow($query, $data);
    }

    /**
     * selectProductsStoresAndPricesForList
     *
     * @return array
     */
    public function selectProductsStoresAndPricesForList(): array
    {
        $query = "SELECT products.name, products.id_products, GROUP_CONCAT(stores.name,',', prices.amount) AS prices_stores,
        (products.stock_min - products.stock_actual + 1)  AS number_item
                  FROM products, prices, stores WHERE products.id_products = prices.id_products
                AND stores.id_store = prices.id_store AND products.stock_actual <= products.stock_min
                GROUP BY products.id_products, products.name";

        return $this->db->read($query);
    }
}
