<?php

namespace App\Models;

use App\Core\Database\Database;

class Product extends Model
{
    /**
     * insert
     *
     * @param  string $name
     * @param  int $stock_min
     * @param  int $stock_actual
     * @param  int $recurent
     * @return bool
     */
    public static function insert(string $name, int $stockMin, int $stockActual, int $recurent): bool
    {
        $query = "INSERT INTO products(name, stock_min, stock_actual, recurrent) 
                VALUES(:name, :stock_min, :stock_actual, :recurent)";

        $data = [];
        $data['name'] = $name;
        $data['stock_min'] = $stockMin;
        $data['stock_actual'] = $stockActual;
        $data['recurent'] = $recurent;

        return Database::getInstance()->write($query, $data);
    }

    public static function update(int $idProduct, string $name, int $stockMin, int $stockActual, int $recurent): bool
    {
        $query = "UPDATE products SET name = :name, stock_min = :stock_min, stock_actual = :stock_actual, recurrent = :recurrent WHERE id_products = :id_products";

        $data = [];
        $data['id_products'] = $idProduct;
        $data['name'] = $name;
        $data['stock_min'] = $stockMin;
        $data['stock_actual'] = $stockActual;
        $data['recurrent'] = $recurent;

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
}
