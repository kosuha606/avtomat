<?php

namespace Avtomat\Box;

use Avtomat\Contract\BoxContract;
use Avtomat\DependencyInjection\DI;
use Avtomat\Util\StrUtil;

/**
 * Class StartBox
 * @package Avtomat\Box
 */
class StartBox extends Box implements BoxContract
{
    public $isEditable = false;

    /**
     * @param $inputData
     */
    public function run()
    {
        StrUtil::debug('Вызван блок начала');
        $this->getResultsStorage()->write($this, 'start data');
        $this->getController()->go($this, 'output');
    }
}