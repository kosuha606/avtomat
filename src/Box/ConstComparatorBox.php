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
    public function run()
    {
        $constant = $this->nextArgument();
        StrUtil::writeln('Сравниваю данный от метки data с константой '.$constant);
        $data = $this->getController()->call($this, 'data');
        $this->getResultsStorage()->write(
            $this,
            $this->getResultsStorage()->read($data) === $constant
        );
    }
}