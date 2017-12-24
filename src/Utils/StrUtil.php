<?php

namespace Avtomat\Utils;

use Avtomat\Contracts\UtilContract;
use Avtomat\DependencyInjection\DI;

/**
 * Набор помошников для работы со сроками
 * @package Avtomat\Utils
 */
class StrUtil implements UtilContract
{
    /**
     * @param $message
     */
    public static function writeln($message)
    {
        echo $message."\n";
    }

    /**
     * @param $message
     */
    public static function debug($message)
    {
        $isDebug = DI::get('parameters_bag')->get('debug_mode');
        if ($isDebug) {
            echo $message."\n";
        }
    }
}