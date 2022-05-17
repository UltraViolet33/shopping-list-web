<?php

namespace App\Models;

use App\Core\Database\Database;


class Product extends Model
{

    private int $id;
    private string $name;
    private int $stockActual;
    private int $stockMin;
    private int $recurrent;

    /**
     * insert
     *
     * @param  string $name
     * @param  int $stockMin
     * @param  int $stockActual
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
}
