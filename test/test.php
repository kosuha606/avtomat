<?php

require '../vendor/autoload.php';

use Avtomat\Utils\StrUtil;

StrUtil::writeln('BlackBox v.1.0.0');

$factory = new \Avtomat\Factory\BlackBoxFactory();
$algorithm = new \Avtomat\Box\AlgorithmBox('TestAlgo', $factory);
$algorithm->run();
