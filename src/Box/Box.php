<?php

namespace Avtomat\Box;

use Avtomat\Contracts\BoxContract;
use Avtomat\DependencyInjection\DI;
use Avtomat\Utils\StrUtil;

/**
 * Базовый класс для всех черных ящиков
 */
class Box implements BoxContract
{
    protected $id;
    private $result;
    protected $labels = [
        'input',
        'output',
    ];
    /**
     * @var AlgorithmBox
     */
    private $baseAlogrithm;

    function run($inputData)
    {
        StrUtil::writeln(sprintf('Run is not implemented in class %s! Check this class!', get_class($this)));

    }

    public function setBaseAlgorithm(AlgorithmBox $baseAlgorithm)
    {
        $this->baseAlogrithm = $baseAlgorithm;
    }

    public function getBaseAlgorithm()
    {
        return $this->baseAlogrithm;
    }

    function getNextBox()
    {

    }

    function getId()
    {
        return $this->id;
    }

    function getLabels()
    {
        return $this->labels;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setLabels($labels)
    {
        $this->labels = $labels;
    }

    public function getName()
    {
        $path = explode('\\', static::class);
        $className = array_pop($path);
        return str_replace('Box', '', $className).'::'.$this->getId();
    }

    public function getResult()
    {
        return $this->result;
    }
}