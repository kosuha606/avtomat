<?php

namespace Avtomat\Box;

use Avtomat\Contract\AlgorithmContract;
use Avtomat\Contract\BoxFactoryInterface;
use Avtomat\DependencyInjection\DI;
use Avtomat\Exception\AlgoBadConfigException;
use Avtomat\Exception\AlgoFileNotFoundException;
use Avtomat\Exception\NoAlgoNameException;
use Avtomat\Util\StrUtil;

/**
 * Алгоритм - основная точка выхода
 * для запуска всех алгоритмов
 *
 * @package Avtomat\Box
 */
class AlgorithmBox extends Box implements AlgorithmContract
{
    public $group = 'Simple';

    /**
     * @var string
     */
    private $name = 'undefined';

    /**
     * @var string
     */
    private $algoDir = 'algorithms';

    /**
     * @var mixed
     */
    private $inputData;

    public function init()
    {
        $algoName = $this->name === 'undefined' ? $this->nextArgument() : $this->name;
        if (!$algoName) {
            throw new NoAlgoNameException('Алгоритм обязательно должен иметь имя!');
        }

        $algorithmDir = DI::get('parameters_bag')->get('algoDir');
        $algorithmPath = $algorithmDir.$algoName;
        if (!is_file($algorithmPath)) {
            throw new AlgoFileNotFoundException('Файл алгоритма не найден!');
        }

        $algorithmDataText = file_get_contents($algorithmPath);
        $algorithmData = json_decode($algorithmDataText, true);
        if (!$algorithmData['objects'] || !$algorithmData['relations']) {
            throw new AlgoBadConfigException('Алгоритм не правильно сконфигурирован! отсутствуют ключи objects или relations');
        }

        $this->getFactory()->setAlgorithmData($algorithmData);
    }

    /**
     * @param null $inputData
     */
    public function run()
    {
        $this->init();
        StrUtil::debug(sprintf('Run algorithm %s', $this->name));
        StrUtil::debug('==============================');

        $inputData = $this->inputData;
        $self = $this;
        $startBox = $this->findStart();
        $this->getResultsStorage()->write($startBox, $inputData);
        $this->getController()->go($startBox, 'input', function($output) use ($self, $inputData) {
            $self->getInputsStorage()->write(
                $output,
                $inputData
            );
        });
        $endBox = $this->findEnd();

        return $this->getResultsStorage()->read($endBox);
    }

    /**
     * @param $inputData
     */
    public function setInputData($inputData)
    {
        $this->inputData = $inputData;
    }

    /**
     * @return StartBox|null
     */
    private function findStart()
    {
        $allObjects = $this->getFactory()->getObjects();
        $startBox = null;
        foreach ($allObjects as $object) {
            if ($object instanceof StartBox) {
                $startBox = $object;
                break;
            }
        }

        return $startBox;
    }

    /**
     * @return EndBox|null
     */
    private function findEnd()
    {
        $allObjects = $this->getFactory()->getObjects();
        $endBox = null;
        foreach ($allObjects as $object) {
            if ($object instanceof EndBox) {
                $endBox = $object;
                break;
            }
        }

        return $endBox;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}