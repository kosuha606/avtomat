<?php
/**
 * Created by PhpStorm.
 * User: kosuha
 * Date: 03.01.18
 * Time: 10:38
 */

namespace Avtomat\Box;


class IncrementResultBox extends Box
{
    public $group = 'Modifier';

    public function run()
    {
        $data = $this->getController()->getInputData();
//        var_dump($data);
        foreach ($data as &$datum) {
            $datum++;
        }
//        var_dump($data);
        $this->getController()->setInputData($data);
        $this->getController()->go($this, 'output');
    }
}