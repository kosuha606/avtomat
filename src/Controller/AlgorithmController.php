<?php

namespace Avtomat\Controller;

use Avtomat\DependencyInjection\DI;
use Avtomat\Utils\StrUtil;

/**
 * Class AlgorithmController
 * @package Avtomat\Controller
 */
class AlgorithmController
{
    /**
     * Передать управление по метке
     * @param $box
     * @param $label
     */
    public function go($box, $label)
    {
        StrUtil::writeln('--->Go to label--->');
        $factory = DI::get('factory');
        $object = $factory->getObjectByRelation($box->getName().'_'.$label);
        $object->run($box->getResult());
    }

    /**
     * Выполнить запуск бокса по метке
     * @param $box
     * @param $label
     */
    public function call($box, $label)
    {
        StrUtil::writeln('<---Call by label<---');
        $factory = DI::get('factory');
        $object = $factory->getObjectByRelation($box->getName().'_'.$label);
        $object->run($box->getResult());
    }
}