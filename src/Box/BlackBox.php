<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;

/**
 * Базовый класс для всех черных ящиков
 */
class BlackBox implements BoxContract
{
    protected $id;
    protected $labels = [
        'input',
        'output',
    ];

    function getId()
    {
        return $this->id;
    }

    function getLabels()
    {
        return $this->labels;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setLabels($labels)
    {
        $this->labels = $labels;
    }
}