<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;
use Avtomat\Utils\StrUtil;

/**
 * Class ConstBox
 * @package Avtomat\Box
 */
class ConstBox extends Box implements BoxContract
{
    public function run()
    {
        $constant = $this->nextArgument();
        StrUtil::debug('Блок получения костанты '.$constant);
        $this->getResultsStorage()->write($this, $constant);
    }
}