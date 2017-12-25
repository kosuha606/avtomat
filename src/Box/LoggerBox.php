<?php
/**
 * Created by PhpStorm.
 * User: kosuha
 * Date: 23.12.17
 * Time: 21:50
 */

namespace Avtomat\Box;

use Avtomat\Contract\BoxContract;
use Avtomat\Util\StrUtil;

class LoggerBox extends Box implements BoxContract
{
    public function run()
    {
        $data = $this->nextArgument();
        StrUtil::writeln($data);
        $this->getController()->go($this, 'output');
    }
}