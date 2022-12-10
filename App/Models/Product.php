<?php

namespace App\Models;

use App\Core\Database\Database;
use PhpParser\Node\Expr\Cast\Object_;

class Product extends Model
{

    /**
     * create
     *
     * @param  array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $query = "INSERT INTO products(name, stock_min, stock_actual, recurrent) 
        VALUES(:name, :stock_min, :stock_actual, :recurent)";

        return Database::getInstance()->write($query, $data);
    }


    /**
     * update
     *
     * @param  array $data
     * @return bool
     */
    public function update(array $data): bool
    {
        $query = "UPDATE products SET name = :name, stock_min = :stock_min, stock_actual = :stock_actual, recurrent = :recurrent
        WHERE id_products = :id_products";
        return Database::getInstance()->write($query, $data);
    }


    /**
     * selectAll
     *
     * @return array
     */
    public function selectAll(): array
    {
        $query = "SELECT * FROM $this->table";
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
        $query = "UPDATE products SET stock_actual = :stock WHERE id_products = :id";
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
        $query = "SELECT *  FROM $this->table WHERE stock_actual <= stock_min";
        return $this->db->read($query);
    }

    /**
     * getSingleProduct
     *
     * @param  int $idProduct
     * @return object
     */
    public function getSingleProduct(int $idProduct): object
    {
        $query = "SELECT *  FROM $this->table WHERE id_products = :id_product";
        return $this->db->read($query, ['id_product' => $idProduct])[0];
    }

    /**
     * deleteProduct
     *
     * @param  int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        $query = "DELETE FROM $this->table WHERE id_products = :id_product";
        return $this->db->write($query, ['id_product' => $id]);
    }

    /**
     * selectOneById
     *
     * @param  int $id
     * @return object
     */
    public function selectOneById(int $id): object
    {
        $query = "SELECT * FROM $this->table as prod
         WHERE prod.id_products = :id_products";

        return $this->db->readOneRow($query, ['id_products' => $id]);
    }


    /**
     * addStoreToProduct
     *
     * @param  array $data
     * @return bool
     */
    public function addStoreToProduct(array $data): bool
    {
        $query = "INSERT INTO prices(amount, id_products, id_stores) VALUES(:amount, :id_products, :id_stores)";
        return $this->db->write($query, $data);
    }


    /**
     * selectStoresAndPrice
     *
     * @param  int $id
     * @return array
     */
    public function selectStoresAndPrice(int $id): array
    {
        $query = "SELECT prices.amount, stores.name FROM prices 
        INNER JOIN stores ON stores.id_stores = prices.id_stores WHERE prices.id_products = :id_products";
        return $this->db->read($query, ["id_products" => $id]);
    }
}
