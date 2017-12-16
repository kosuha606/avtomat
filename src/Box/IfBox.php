<?php

namespace Avtomat\Box;

/**
 * Условие
 */
class IfBox
{
    public function __construct()
    {
        $this->labels[] = 'comparator';
        $this->labels[] = 'data';
        $this->labels[] = 'then';
        $this->labels[] = 'else';
    }
}