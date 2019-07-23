<?php

namespace App\Utils;

class Generator
{
    /**
     * 取五個亂碼
     * @return string
     */
    public static function getSpecifiedRand($num = 1): string
    {
        return substr(uniqid(), ($num * -1));
    }
}