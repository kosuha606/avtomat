<?php
/**
 * Created by PhpStorm.
 * User: kosuha
 * Date: 03.01.18
 * Time: 10:38
 */

namespace Avtomat\Box;


use Avtomat\Contract\WriterContract;

class IncrementResultBox extends Box implements WriterContract
{
    public $group = 'Modifier';

    public function run()
    {
        $data = $this->getController()->getInputData();

        foreach ($data as &$datum) {
            $datum++;
        }

        $this->getController()->setInputData($this, $data);
        $this->getController()->go($this, 'output');
    }
}