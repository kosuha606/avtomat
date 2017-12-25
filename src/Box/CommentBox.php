<?php

namespace Avtomat\Box;

use Avtomat\Contract\BoxContract;

class CommentBox extends Box implements BoxContract
{
    public $color = '#dac062';

    public $inputLabels = [];

    public $outputLabels = ['output'];
}