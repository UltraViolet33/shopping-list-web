<?php

namespace App\Core\Database;

/**
 * Singleton Pattern
 */
class Config
{

    private static $instance;
    public static array $dbConfig;

    /**
     * __construct
     *
     * @return void
     */
    private function __construct()
    {
        self::$dbConfig['db_type'] = "mysql";
        self::$dbConfig['db_host'] = "localhost";
        self::$dbConfig['db_name'] = "practice-design-pattern";
        self::$dbConfig['db_user'] = "root";
        self::$dbConfig['db_password'] = "";
    }


    /**
     * init
     *
     * @return self
     */
    private static function init(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * getValue
     *
     * @param  string $key
     * @return string
     */
    public static function getValue(string $key): string
    {
        self::init();
        return self::$dbConfig[$key];
    }
}
