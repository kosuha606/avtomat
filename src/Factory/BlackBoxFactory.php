<?php

namespace Avtomat\Factory;

use Avtomat\Box\AlgorithmBox;
use Avtomat\Box\CommentBox;
use Avtomat\Box\ConstBox;
use Avtomat\Box\ConstComparatorBox;
use Avtomat\Box\EndBox;
use Avtomat\Box\IfBox;
use Avtomat\Box\IncrementResultBox;
use Avtomat\Box\LoggerBox;
use Avtomat\Box\StartBox;
use Avtomat\Box\VarBox;
use Avtomat\Contract\BoxFactoryInterface;
use Avtomat\Exception\NotFoundBlackBoxException;

/**
 * Class BlackBoxFactory
 * @package Avtomat\Factory
 */
class BlackBoxFactory implements BoxFactoryInterface
{
    /**
     * @var
     */
    private $data;

    /**
     * @var array
     */
    private $objects = [];

    /**
     * @var array
     */
    private $boxes = [];

    /**
     * @var array
     */
    private $relations = [];

    /**
     * @var array
     */
    private $algorithmData = [];

    public function __construct()
    {
        $this->boxes = [
            'Algorithm' => new AlgorithmBox(),
            'Const' => new ConstBox(),
            'ConstComparator' => new ConstComparatorBox(),
            'End' => new EndBox(),
            'If' => new IfBox(),
            'Logger' => new LoggerBox(),
            'Start' => new StartBox(),
            'Comment' => new CommentBox(),
            'IncrementResult' => new IncrementResultBox(),
            'Var' => new VarBox(),
        ];
    }

    /**
     * @param $newBoxes
     */
    public function addBoxes($newBoxes)
    {
        $this->boxes = array_merge($this->boxes, $newBoxes);
    }

    /**
     * @return array
     */
    public function getBoxes()
    {
        return $this->boxes;
    }

    /**
     * @param $data
     */
    public function setAlgorithmData($data, $algorithm = null)
    {
        $this->data = $data;
        $this->relations[$algorithm] = $data['relations'];

        foreach ($data['objects'] as $object) {
            $this->objects[$algorithm][$object['name']] = $this->create($object, $algorithm);
        }
    }

    /**
     * @param $relation
     * @return mixed
     */
    public function getObjectByRelation($relation, $algorithm = null)
    {
        if (isset($this->relations[$algorithm][$relation])) {
            $split = explode('_', $this->relations[$algorithm][$relation]);
            return $this->objects[$algorithm][$split[0]];
        }
    }

    /**
     * @param $relation
     * @return mixed
     */
    public function getObjectByRelationReverse($relation, $algorithm = null)
    {
        $reverseRelations = array_flip($this->relations[$algorithm]);
        if (isset($reverseRelations[$relation])) {
            $split = explode('_', $reverseRelations[$relation]);
            return $this->objects[$algorithm][$split[0]];
        }
    }

    /**
     * @return array
     */
    public function getObjects($algorithm)
    {
        return $this->objects[$algorithm];
    }

    /**
     * @param $objectName
     * @return mixed
     * @throws NotFoundBlackBoxException
     */
    public function create($object, $algorithm = null)
    {
        $objectName = $object['name'];
        $arguments = $object['arguments'];
        $split = explode('::', $objectName);
        $boxName = $split[0];
        $boxId = $split[1];

        if (isset($this->boxes[$boxName])) {
            $object = clone $this->boxes[$boxName];
            $object->setId($boxId);
            $object->setArguments($arguments);
            /** Каждый бокс должен знать в каком он алгоритме */
            $object->setAlgorithm($algorithm);
            return $object;
        }

        throw new NotFoundBlackBoxException(sprintf('Попытка создвать BlackBox c не известным именем %s', $objectClass));
    }
}