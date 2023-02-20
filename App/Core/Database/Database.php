<?php

namespace App\Core\Database;

use \PDO;

class Database
{

    private ?PDO $PDOInstance = null;
    private static ?self $instance = null;


    private function __construct()
    {
        $string = Config::getValue('db_type') . ":host=" . Config::getValue('db_host') . ";dbname=" . Config::getValue('db_name');
        $this->PDOInstance  = new PDO($string, Config::getValue('db_user'), Config::getValue('db_password'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }


    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }


    public static function getNewInstance(): self
    {
        return new Database();
    }

    public function read(string $query,  array $data = array(), int $method = PDO::FETCH_OBJ, $class = null): bool|array
    {
        $statement = $this->PDOInstance->prepare($query);
        $result = $statement->execute($data);

        if ($result) {
            $data = $statement->fetchAll($method);

            if ($method === PDO::FETCH_CLASS) {
                $data = $statement->fetchAll($method, $class);
            }
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }
        return [];
    }


    public function readOneRow(string $query, array $data = []): bool|object
    {
        $statement = $this->PDOInstance->prepare($query);
        $result = $statement->execute($data);

        if ($result) {
            return $statement->fetch(PDO::FETCH_OBJ);
        }

        return false;
    }


    public function write(string $query, array $data = array()): bool
    {
        $statement = $this->PDOInstance->prepare($query);
        $result = $statement->execute($data);

        if ($result) {
            return true;
        }
        return false;
    }


    public function getLastInsertId(): int
    {
        return $this->PDOInstance->lastInsertId();
    }
}
