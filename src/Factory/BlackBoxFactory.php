<?php

namespace Avtomat\Factory;

use Avtomat\Box\Box;
use Avtomat\Contracts\BoxFactoryInterface;
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
    private $relations = [];

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
        $namespace = 'Avtomat\\Box\\';
        $objectClass = $namespace.$boxName.'Box';
        if (class_exists($objectClass)) {
            $object = new $objectClass($boxId, $arguments);
            if ($object instanceof Box) {
                return $object;
            }
        }

        throw new NotFoundBlackBoxException(sprintf('Попытка создвать BlackBox c не известным именем %s', $objectClass));
    }
}