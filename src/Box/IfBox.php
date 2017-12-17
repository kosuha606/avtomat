<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;
use Avtomat\DependencyInjection\DI;
use Avtomat\Utils\StrUtil;

/**
 * Условие
 */
class IfBox extends Box implements BoxContract
{
    public function __construct()
    {
        $this->labels[] = 'comparator';
        $this->labels[] = 'data';
        $this->labels[] = 'then';
        $this->labels[] = 'else';
    }

    public function run($inputData)
    {
        StrUtil::writeln('If is working');
        DI::get('controller')->go($this, 'output');
    }
}