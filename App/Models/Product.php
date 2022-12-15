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
        $query = "SELECT * , (stock_min - stock_actual) AS number_item FROM $this->table WHERE stock_actual <= stock_min";
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
        $query = "SELECT * FROM $this->table WHERE id_products = :id_product";
        return $this->db->read($query, ['id_product' => $idProduct])[0];
    }

    /**
     * deleteProduct
     *
     * @param  int $id
     * @return bool
     */
    public function delete(int $id): bool
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
     * @return array | bool
     */
    public function selectStoresAndPrice(int $id): array|bool
    {
        $query = "SELECT prices.amount, stores.name FROM prices 
        INNER JOIN stores ON stores.id_stores = prices.id_stores WHERE prices.id_products = :id_products";
        return $this->db->read($query, ["id_products" => $id]);
    }


    /**
     * getAllStoresProduct
     *
     * @param  int $id
     * @return array | bool
     */
    public function getAllStoresProduct(int $id): array|bool
    {
        $query = "SELECT id_stores FROM prices WHERE id_products = :id_products";
        return $this->db->read($query, ["id_products" => $id]);
    }

    /**
     * selectPriceByStoreAndProduct
     *
     * @param array $data
     * @return bool|object
     */
    public function selectPriceByStoreAndProduct(array $data): bool|object
    {
        $query = "SELECT amount FROM prices WHERE id_products = :id_products AND id_stores = :id_stores";
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
        (products.stock_min - products.stock_actual)  AS number_item
                  FROM products, prices, stores WHERE products.id_products = prices.id_products
                AND stores.id_stores = prices.id_stores AND products.stock_actual <= products.stock_min
                GROUP BY products.id_products, products.name";

        return $this->db->read($query);
    }
}
