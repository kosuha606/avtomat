<?php

require '../vendor/autoload.php';

use Avtomat\Utils\StrUtil;

StrUtil::writeln('BlackBox v.1.0.0');

$algorithm = new \Avtomat\Box\AlgorithmBox('TestAlgo');
$algorithm->run();
