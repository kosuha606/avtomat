<?php

namespace Avtomat\Box;

use Avtomat\Contract\BoxContract;
use Avtomat\Util\StrUtil;

/**
 * Class ConstBox
 * @package Avtomat\Box
 */
class ConstBox extends Box implements BoxContract
{
    public $group = 'Simple';

    public function run()
    {
        $constant = $this->nextArgument();
        StrUtil::debug('Блок получения костанты '.$constant);
        $this->getResultsStorage()->write($this, $constant);
    }
}