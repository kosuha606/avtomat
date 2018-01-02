<?php

namespace Avtomat\Factory;

use Avtomat\Box\CommentBox;
use Avtomat\Box\ConstBox;
use Avtomat\Box\ConstComparatorBox;
use Avtomat\Box\EndBox;
use Avtomat\Box\IfBox;
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

    public function __construct()
    {
        $this->boxes = [
            'Const' => new ConstBox(),
            'ConstComparator' => new ConstComparatorBox(),
            'End' => new EndBox(),
            'If' => new IfBox(),
            'Logger' => new LoggerBox(),
            'Start' => new StartBox(),
            'Comment' => new CommentBox(),
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
    public function setAlgorithmData($data)
    {
        $this->data = $data;
        $this->relations = $data['relations'];

        foreach ($data['objects'] as $object) {
            $this->objects[$object['name']] = $this->create($object);
        }
    }

    /**
     * @param $relation
     * @return mixed
     */
    public function getObjectByRelation($relation)
    {
        if (isset($this->relations[$relation])) {
            $split = explode('_', $this->relations[$relation]);
            return $this->objects[$split[0]];
        }
    }

    /**
     * @return array
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @param $objectName
     * @return mixed
     * @throws NotFoundBlackBoxException
     */
    public function create($object)
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
            return $object;
        }

        throw new NotFoundBlackBoxException(sprintf('Попытка создвать BlackBox c не известным именем %s', $objectClass));
    }
}