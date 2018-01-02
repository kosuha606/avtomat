<?php

namespace Avtomat\Storage;

use Avtomat\Box\Box;
use Avtomat\Contract\StorageContract;

abstract class AbstractStorage implements StorageContract
{
    /**
     * @var array
     */
    private $storage = [];

    /**
     * @param Box $box
     * @param     $data
     */
    public function write(Box $box, $data)
    {
        $this->storage[$box->getName()] = $data;
    }

    /**
     * @param Box $box
     * @return mixed
     */
    public function read(Box $box)
    {
        if (isset($this->storage[$box->getName()])) {
            return $this->storage[$box->getName()];
        } else {
            return null;
        }
    }
}