<?php

require '../vendor/autoload.php';

use Avtomat\Utils\StrUtil;

StrUtil::writeln('BlackBox v.1.0.0');

/**
 * 1 - Какой объект должен хранить связи между боксами?
 * 2 - Какой объект должен создавать боксы?
 */

$factory = new \Avtomat\Factory\BlackBoxFactory();
$algorithm = new \Avtomat\Box\AlgorithmBox('TestAlgo', $factory);
$algorithm->run();
