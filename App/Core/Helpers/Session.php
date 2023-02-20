<?php

namespace App\Core\Helpers;

class Session
{

    public static function init(): void
    {
        if (empty(session_id())) {
            session_start();
        }
    }


    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }



    public static function get(string $key): string|bool
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }


    public static function setMessage(string $value): void
    {
        $_SESSION['msg'] = $value;
        var_dump($_SESSION);
    }


    public static function getMessage(): string|bool
    {
        $msg = self::get('msg');
        return $msg;
    }


    public static function unset(string $key): bool
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }

        return false;
    }
}
