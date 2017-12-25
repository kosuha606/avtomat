<?php

namespace Avtomat\Box;

use Avtomat\Contract\BoxContract;
use Avtomat\Util\StrUtil;

/**
 * Class EndBox
 * @package Avtomat\Box
 */
class EndBox extends Box implements BoxContract
{
    public $isEditable = false;

    public function run()
    {
        StrUtil::debug('Блок конца алгоритма');
    }
}