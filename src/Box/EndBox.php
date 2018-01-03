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

    public $outputLabels = ['output', 'result'];

    public $inputLabels = ['input'];

    public function run()
    {
        $data = null;
        StrUtil::debug('Блок конца алгоритма');
        $data = $this->getController()->getInputData();
        $this->getResultsStorage()->write($this, $data);

        return $data;
    }
}