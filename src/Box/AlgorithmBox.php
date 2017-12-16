<?php

namespace Avtomat\Box;

class AlgorithmBox
{
    private $map = [];
    private $relations = [];

    public function add(BlackBox $box)
    {
        $this->map[$box->getId()] = $box;
    }

    public function relation(
        BlackBox $box1,
        $label1,
        BlackBox $box2,
        $label2
    ) {
        $boxLabel1 = $box1->getId().'_'.$label1;
        $boxLabel2 = $box2->getId().'_'.$label2;
        $this->relations[$boxLabel1] = $boxLabel2;
        $this->relations[$boxLabel2] = $boxLabel1;
    }

    public function run()
    {
        writeln('Run algorithm');
    }

    public function dump()
    {
        var_dump($this->relations);
    }
}