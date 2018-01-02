<?php

namespace Avtomat\Bag;

use Avtomat\Exception\LogicException;

class ParametersBag
{
    private $parameters = [
        'debug_mode' => true
    ];

    /**
     * @param $parameterKey
     * @return mixed
     * @throws LogicException
     */
    public function get($parameterKey)
    {
        if (isset($this->parameters[$parameterKey])) {
            return $this->parameters[$parameterKey];
        }

        throw new LogicException('Неверная конфигурация параметров!');
    }
}