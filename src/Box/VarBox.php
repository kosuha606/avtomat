<?php

namespace Avtomat\Box;


use Avtomat\Util\StrUtil;

class VarBox extends Box
{
    public $group = 'Simple';

    public $outputLabels = [];

    public $inputLabels = ['input', 'result', 'data'];

    public function run()
    {
        $data = $this->getController()->call($this, 'data');
        $data = $this->getResultsStorage()->read($data);
        StrUtil::debug('Переменная с значением: '.$data);
        $this->getResultsStorage()->write(
            $this,
            $data
        );
    }
}