<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;
use Avtomat\Utils\StrUtil;

/**
 * Class EndBox
 * @package Avtomat\Box
 */
class EndBox extends Box implements BoxContract
{
    public function run()
    {
        StrUtil::debug('Блок конца алгоритма');
    }
}