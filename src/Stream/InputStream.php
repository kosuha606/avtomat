<?php

namespace Avtomat\Stream;

use Avtomat\Contract\WriterContract;
use Avtomat\Exception\LogicException;

class InputStream
{
    private $data;

    public function write($writer, $data)
    {
        if ($writer instanceof WriterContract) {
            $this->data = $data;
        } else {
            throw new LogicException(sprintf('Класс (%s) не может писать в поток данных!', get_class($writer)));
        }
    }

    public function read()
    {
        return $this->data;
    }
}