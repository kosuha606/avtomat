<?php

namespace Avtomat\Box;

use Avtomat\Contracts\AlgorithmContract;
use Avtomat\Contracts\BoxFactoryInterface;
use Avtomat\DependencyInjection\DI;
use Avtomat\Exception\AlgoBadConfigException;
use Avtomat\Exception\AlgoFileNotFoundException;
use Avtomat\Exception\NoAlgoNameException;
use Avtomat\Utils\StrUtil;

/**
 * Алгоритм - основная точка выхода
 * для запуска всех алгоритмов
 *
 * @package Avtomat\Box
 */
class AlgorithmBox extends Box implements AlgorithmContract
{
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

    /**
     * AlgorithmBox constructor.
     * @param $algoName
     * @throws AlgoBadConfigException
     * @throws AlgoFileNotFoundException
     * @throws NoAlgoNameException
     */
    public function __construct($algoName)
    {
        if (!$algoName) {
            throw new NoAlgoNameException('Алгоритм обязательно должен иметь имя!');
        }
        $this->name = $algoName;

        $algorithmPath = $this->algoDir.'/'.$algoName.'.json';
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
        StrUtil::debug(sprintf('Run algorithm %s', $this->name));
        StrUtil::debug('==============================');

        $inputData = $this->inputData;
        $self = $this;
        $startBox = $this->findStart();
        $this->getController()->go($startBox, 'input', function($output) use ($self, $inputData) {
            $self->getInputsStorage()->write(
                $output,
                $inputData
            );
        });
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
}