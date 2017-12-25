<?php

namespace Avtomat\Api;

use Avtomat\Box\AlgorithmBox;
use Avtomat\Contract\ApiContract;
use Avtomat\DependencyInjection\DI;

/**
 * Интерфейс для выполнения работы с
 * пакетом со стороны клиентсого приложения
 *
 * @package Avtomat\Api
 */
class Avtomat implements ApiContract
{
    /**
     * Возвращает все доступные для использования
     * в алгоритмах объекты
     */
    public static function getAvailableObjects()
    {
        return DI::get('factory')->getBoxes();
    }

    /**
     * @param array $boxes
     */
    public static function addBoxes($boxes = [])
    {
        DI::get('factory')->addBoxes($boxes);
    }

    /**
     * Изменяет алгоритм
     *
     * @param $algoName
     * @param $config
     */
    public function changeAlgorithm($algoName, $config)
    {
        // TODO: Implement changeAlgorithm() method.
    }

    /**
     * @param $algorithmName
     * @param $inputData
     */
    public static function run($algorithmName, $inputData)
    {
        $algorithm = new AlgorithmBox($algorithmName);
        $algorithm->setInputData($inputData);
        $algorithm->run();
    }
}