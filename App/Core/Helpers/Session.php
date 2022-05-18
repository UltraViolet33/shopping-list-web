<?php

namespace App\Core\Helpers;

class Session
{

    /**
     * init
     *
     * @return void
     */
    public static function init(): void
    {
        if (empty(session_id())) {
            session_start();
        }
    }


    /**
     * set
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get
     *
     * @param  string $key
     * @return string|bool
     */
    public static function get(string $key): string|bool
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }

    /**
     * setMessage
     *
     * @param  string $value
     * @return void
     */
    public static function setMessage(string $value): void
    {
        $_SESSION['msg'] = $value;
        var_dump($_SESSION);
    }

    /**
     * getMessage
     *
     * @return string|bool
     */
    public static function getMessage(): string|bool
    {
        $msg = self::get('msg');
        return $msg;
    }

    /**
     * unset
     *
     * @param  string $key
     * @return bool
     */
    public static function unset(string $key): bool
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }

        return false;
    }
}
