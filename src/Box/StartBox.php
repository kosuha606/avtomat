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

    public $outputLabels = ['output', 'input-data'];

    /**
     * @param $inputData
     */
    public function run()
    {
        StrUtil::debug('Вызван блок начала');
        $inputData = $this->getResultsStorage()->read($this);
//        var_dump($inputData);
        $this->getController()->setInputData($inputData);
        $this->getResultsStorage()->write($this, 'start data');
        $this->getController()->go($this, 'output');
    }
}