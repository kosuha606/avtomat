<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;

/**
 * Условие
 */
class IfBox implements BoxContract
{
    public function __construct()
    {
        $this->labels[] = 'comparator';
        $this->labels[] = 'data';
        $this->labels[] = 'then';
        $this->labels[] = 'else';
    }
}