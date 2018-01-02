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
        StrUtil::debug('Блок конца алгоритма');
        $result = $this->getController()->getRelation($this, 'result');
        $data = $this->getResultsStorage()->read($result);
        $this->getResultsStorage()->write($this, $data);

        return $data;
    }
}