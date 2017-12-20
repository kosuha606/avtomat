<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;
use Avtomat\Utils\StrUtil;

/**
 * Class EqualConstBox
 * @package Avtomat\Box
 */
class EqualConstBox extends Box implements BoxContract
{
    public function run($inputData)
    {
        StrUtil::writeln('Equal const box');
    }
}