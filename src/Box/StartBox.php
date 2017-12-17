<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;
use Avtomat\DependencyInjection\DI;
use Avtomat\Utils\StrUtil;

/**
 * Class StartBox
 * @package Avtomat\Box
 */
class StartBox extends Box implements BoxContract
{
    /**
     * @param $inputData
     */
    public function run($inputData)
    {
        StrUtil::writeln('Start is working');
        DI::get('controller')->go($this, 'output');
    }

    /**
     * @param $inputData
     */
    public function setInputData($inputData)
    {

    }
}