<?php

require '../vendor/autoload.php';

use Avtomat\Utils\StrUtil;
use Avtomat\Api\Avtomat;

StrUtil::writeln('BlackBox v.1.0.0');
Avtomat::run('TestAlgo', []);