<?php

namespace Avtomat\Utils;

use Avtomat\Contracts\UtilContract;

/**
 * Набор помошников для работы со сроками
 * @package Avtomat\Utils
 */
class StrUtil implements UtilContract
{
    public static function writeln($message)
    {
        echo $message."\n";
    }
}