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
    public function go($box, $label, $callBack = null)
    {
        StrUtil::writeln('--->Go to '.$box->getName().'--->');
        $factory = DI::get('factory');
        $object = $factory->getObjectByRelation($box->getName().'_'.$label);
        if ($callBack && is_callable($callBack)) {
            $callBack($object);
        }
        $object->run($box->getResult());
    }

    /**
     * Выполнить запуск бокса по метке
     * @param $box
     * @param $label
     */
    public function call($box, $label)
    {
        StrUtil::writeln('<---Call by '.$box->getName().'<---');
        $factory = DI::get('factory');
        $object = $factory->getObjectByRelation($box->getName().'_'.$label);
        $object->run($box->getResult());

        return $object;
    }
}