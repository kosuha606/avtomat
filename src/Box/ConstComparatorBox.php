<?php

namespace Avtomat\Box;

use Avtomat\Contract\BoxContract;
use Avtomat\Util\StrUtil;

/**
 * Class EqualConstBox
 * @package Avtomat\Box
 */
class ConstComparatorBox extends Box implements BoxContract
{
    public $group = 'Simple';

    public function run()
    {
        $constant = $this->nextArgument();
        StrUtil::debug('Сравниваю данный от метки data с константой '.$constant);
        $data = $this->getController()->call($this, 'output');
        $this->getResultsStorage()->write(
            $this,
            $this->getResultsStorage()->read($data) === $constant
        );
    }
}