<?php

namespace Avtomat\Contracts;

/**
 * Interface ApiContract
 * @package Avtomat\Contracts
 */
interface ApiContract
{
    public function getAvailableObjects();

    public function changeAlgorithm($algoName, $config);
}