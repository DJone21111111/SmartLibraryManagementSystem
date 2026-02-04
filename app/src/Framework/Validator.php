<?php

namespace App\Framework;

class Validator
{
    public static function required(string $value): bool
    {
        return trim($value) !== '';
    }

    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function maxLen(string $value, int $max): bool
    {
        return mb_strlen($value) <= $max;
    }
}
