<?php

require '../vendor/autoload.php';

use Avtomat\Utils\StrUtil;
use Avtomat\Api\Avtomat;

Avtomat::setAlgoDir(__DIR__.'/algorithms/');
$res = Avtomat::run('EmptyAlgo.json', [1,2,3]);
var_dump($res);