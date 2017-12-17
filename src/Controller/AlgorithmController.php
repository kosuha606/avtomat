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
     * @param $box
     * @param $label
     */
    public function go($box, $label)
    {
        StrUtil::writeln('goto label');
        $factory = DI::get('factory');
        $object = $factory->getObjectByRelation($box->getName().'_'.$label);
        $object->run($box->getResult());
    }
}