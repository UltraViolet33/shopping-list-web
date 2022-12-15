<?php

namespace App\Models;

use App\Core\Database\Database;

class Store extends Model
{

    /**
     * create
     *
     * @param  array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $query = "INSERT INTO $this->table(name) VALUES(:name)";
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
        return Database::getInstance()->read($query);
    }


    /**
     * selectOneById
     *
     * @param  int $id
     * @return object
     */
    public function selectOneById(int $id): object
    {
        $query = "SELECT * FROM $this->table WHERE id_stores = :id_stores";
        return Database::getInstance()->readOneRow($query, ["id_stores" => $id]);
    }


    /**
     * update
     *
     * @param  array $data
     * @return bool
     */
    public function update(array $data): bool
    {
        $query = "UPDATE stores SET name = :name WHERE id_stores = :id_stores";
        return Database::getInstance()->write($query, $data);
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

        return Database::getInstance()->read($query, ["id_products" => $id]);
    }


    /**
     * delete
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM $this->table WHERE id_stores = :id_stores";
        return Database::getInstance()->write($query, ["id_stores" => $id]);
    }
}
