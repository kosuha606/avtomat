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
    public function run()
    {
        StrUtil::writeln('Вызван блок начала');
        $this->getResultsStorage()->write($this, 'start data');
        $this->getController()->go($this, 'output');
    }
}