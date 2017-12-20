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
     * @var BoxFactoryInterface
     */
    private $factory;

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

        $factory = DI::get('factory');
        $factory->setAlgorithmData($algorithmData);
        $this->factory = $factory;
    }

    /**
     * @param null $inputData
     */
    public function run($inputData = null)
    {
        StrUtil::writeln(sprintf('Run algorithm %s', $this->name));
        StrUtil::writeln('==============================');

        $startBox = $this->findStart();
        return $startBox->run($inputData);
    }

    /**
     * @return StartBox|null
     */
    private function findStart()
    {
        $allObjects = $this->factory->getObjects();
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