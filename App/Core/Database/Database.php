<?php

namespace App\Core\Database;

use \PDO;

/**
 * Singleton Pattern
 */
class Database
{

    private ?PDO $PDOInstance = null;
    private static ?self $instance = null;

    /**
     * __construct
     *
     * @return void
     */
    private function __construct()
    {
        $string = Config::getValue('db_type') . ":host=" . Config::getValue('db_host') . ";dbname=" . Config::getValue('db_name');
        $this->PDOInstance  = new PDO($string, Config::getValue('db_user'), Config::getValue('db_password'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }


    /**
     * getInstance
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }


    /**
     * getNewInstance
     *
     * @return self
     */
    public static function getNewInstance(): self
    {
        return new Database();
    }

    /**
     * read
     *
     * @param  string $query
     * @param  array $data
     * @param  int $method
     * @return bool|array
     */
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
        return false;
    }


    /**
     * write
     *
     * @param  string $query
     * @param  array $data
     * @return bool
     */
    public function write(string $query, array $data = array()): bool
    {
        $statement = $this->PDOInstance->prepare($query);
        $result = $statement->execute($data);

        if ($result) {
            return true;
        }
        return false;
    }

    /**
     * getLastInsertId
     *
     * @return int
     */
    public function getLastInsertId(): int
    {
        return $this->PDOInstance->lastInsertId();
    }
}
