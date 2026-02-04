<?php

namespace App\Framework;

class TempData
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION['_temp'][$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (!isset($_SESSION['_temp'][$key])) {
            return $default;
        }

        $value = $_SESSION['_temp'][$key];
        unset($_SESSION['_temp'][$key]); 
        return $value;
    }
}
