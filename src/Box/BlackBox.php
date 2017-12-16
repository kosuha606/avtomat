<?php

namespace Avtomat\Box;

/**
 * Базовый класс для всех черных ящиков
 */
class BlackBox
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