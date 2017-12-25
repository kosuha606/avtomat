<?php

namespace Avtomat\Contract;

use Avtomat\Box\Box;

interface StorageContract
{
    public function write(Box $box, $data);
    public function read(Box $box);
}