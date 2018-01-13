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
     * @param $algorithmName
     * @param $inputData
     */
    public static function run($algorithmName, $inputData)
    {
        $algorithm = new AlgorithmBox();
        $algorithm->setId('starter');
        $algorithm->setName($algorithmName);
        $algorithm->setInputData($inputData);

        return $algorithm->run();
    }

    /**
     * @param $dirPath
     */
    public static function setAlgoDir($dirPath)
    {
        DI::get('parameters_bag')->set('algoDir', $dirPath);
    }

    /**
     * @param $algoFile
     * @return string
     */
    public static function adaptAlgoToGoJS($algoFile)
    {
        $json = file_get_contents($algoFile);
        $adapter = DI::get('json_adapter');
        $adaptedJson = $adapter->adapt(json_decode($json, true));

        return json_encode($adaptedJson);
    }

    /**
     * @param $algoGOJS
     * @param $algoPath
     */
    public static function saveAlgoFromGOJS($algoGOJS, $algoPath)
    {
        $adapter = DI::get('json_adapter');
        $adaptedJson = $adapter->restore(json_decode($algoGOJS, true));

        file_put_contents($algoPath, json_encode($adaptedJson));
    }
}