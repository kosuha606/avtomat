<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;
use Avtomat\Utils\StrUtil;

/**
 * Class EqualConstBox
 * @package Avtomat\Box
 */
class ConstComparatorBox extends Box implements BoxContract
{
    public function run($inputData)
    {
        StrUtil::writeln('Const comparator box');
        $data = $this->getController()->call($this, 'data');
        $this->getResultsStorage()->write(
            $this,
            $this->getResultsStorage()->read($data) === 'constant'
        );
    }
}