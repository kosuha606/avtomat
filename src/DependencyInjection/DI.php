<?php

namespace Avtomat\DependencyInjection;

/**
 * Class DI
 * @package Avtomat\DependencyInjection
 */
class DI
{
    /**
     * @var array
     */
    private static $dependencies = [
        'controller' => 'Avtomat\\Controller\\AlgorithmController',
        'factory' => 'Avtomat\\Factory\\BlackBoxFactory',
        'results_storage' => 'Avtomat\\Storage\\BoxResultsStorage',
        'inputs_storage' => 'Avtomat\\Storage\\BoxInputsStorage',
        'parameters_bag' => 'Avtomat\\Bag\\ParametersBag',
        'json_adapter' => 'Avtomat\\Adapter\\GoJSAdapter',
        'input_stream' => 'Avtomat\\Stream\\InputStream',
    ];

    /**
     * @var array
     */
    private static $dependencyInstances = [];

    /**
     * @param $dependency
     * @return mixed|null
     */
    public static function get($dependency)
    {
        if (isset(self::$dependencies[$dependency])) {
            if (isset(self::$dependencyInstances[$dependency])) {
                return self::$dependencyInstances[$dependency];
            } else {
                self::$dependencyInstances[$dependency] = new self::$dependencies[$dependency];
                return self::$dependencyInstances[$dependency];
            }
        }

        return null;
    }
}