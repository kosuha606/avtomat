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
        StrUtil::writeln('Start box');
        $this->getResultsStorage()->write($this, 'start data');
        $this->getController()->go($this, 'output');
    }
}