<?php

require '../vendor/autoload.php';

use Avtomat\Utils\StrUtil;
use Avtomat\Api\Avtomat;

Avtomat::setAlgoDir(__DIR__.'/algorithms/');
Avtomat::run('EmptyAlgo.json', []);