<?php

namespace App\Models;

use App\Core\Database\Database;


class Product extends Model
{

    private int $id_product;
    private string $name;
    private int $stock_actual;
    private int $stock_min;
    private int $recurrent;

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

    public function selectAll()
    {
        $query = "SELECT * FROM $this->table";
        return $this->db->read($query);
    }


    public function updateStock(int $id, int $stock): bool
    {
        $query = "UPDATE products SET stock_actual = :stock WHERE id_products = :id";
        $data['id'] = $id;
        $data['stock'] = $stock;

        return $this->db->write($query, $data);
    }
}
