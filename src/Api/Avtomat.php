<?php

namespace Avtomat\Api;

use Avtomat\Contracts\ApiContract;

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
    public function getAvailableObjects()
    {
        // TODO: Implement getAvailableObjects() method.
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
}