<?php

namespace Avtomat\Box;


use Avtomat\Util\StrUtil;

class VarBox extends Box
{
    public $outputLabels = ['data'];

    public $inputLabels = ['input', 'result'];

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