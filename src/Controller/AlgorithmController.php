<?php

namespace Avtomat\Controller;

use Avtomat\DependencyInjection\DI;
use Avtomat\Util\StrUtil;

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
        StrUtil::debug('--->Go to '.$box->getName().'--->');
        $factory = DI::get('factory');
        $object = $factory->getObjectByRelation($box->getName().'_'.$label, $box->getAlgorithm());
//        var_dump($object);
        if ($callBack && is_callable($callBack)) {
            $callBack($object);
        }
        $object->run();
    }

    /**
     * Выполнить запуск бокса по метке
     * @param $box
     * @param $label
     */
    public function call($box, $label)
    {
        StrUtil::debug('<---Call by '.$box->getName().'<---');
        $factory = DI::get('factory');
        $object = $factory->getObjectByRelation($box->getName().'_'.$label, $box->getAlgorithm());
        $object->run();

        return $object;
    }

    public function getRelation($box, $label)
    {
        StrUtil::debug('<---Get relation '.$box->getName().'<---');
        $factory = DI::get('factory');
        $object = $factory->getObjectByRelation($box->getName().'_'.$label, $box->getAlgorithm());
        if (!$object) {
            $object = $factory->getObjectByRelationReverse($box->getName().'_'.$label, $box->getAlgorithm());
        }

        return $object;
    }

    /**
     * @return array
     */
    public function getInputData()
    {
        return DI::get('input_stream')->read();
    }

    /**
     * @param array $inputData
     */
    public function setInputData($writer, $inputData)
    {
        DI::get('input_stream')->write($writer, $inputData);
    }
}