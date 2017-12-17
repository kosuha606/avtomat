<?php

namespace Avtomat\Contracts;


interface ApiContract
{
    public function getAvailableObjects();

    public function changeAlgorithm($algoName, $config);
}