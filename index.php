<?php

require 'vendor/autoload.php';

writeln("BlackBox");

// ядро
/**
 * Бокс для реализации условий
 */
class IfBox extends BlackBox {

    public function __construct() {
        $this->labels[] = 'comparator';
        $this->labels[] = 'data';
        $this->labels[] = 'then';
        $this->labels[] = 'else';
    }
}

/**
 * Константа
 */
class ConstBox extends BlackBox {
    
}

/**
 * Сравнение констант
 */
class EqualConstBox extends BlackBox {
    
}

/**
 * Начало алгоритма
 */
class StartBox extends BlackBox {
    
}

/**
 * Конец алгоритма
 */
class EndBox extends BlackBox {
    
}

/**
 * Хранилище боксов
 * Алгоритм
 */
class AlgorithmBox extends BlackBox {

    private $map = [];
    private $relations = [];

    public function add(BlackBox $box) {
        $this->map[$box->getId()] = $box;
    }

    public function relation(
    BlackBox $box1, $label1, BlackBox $box2, $label2
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

    public function dump() {
        var_dump($this->relations);
    }

}

/**
 * Фабрика по созданию 
 * боксов
 */
class BlackBoxFactory {

    private function generateId() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * @param type $boxName
     * @return \BlackBox
     * @throws NotFoundBlackBoxException
     */
    public function create($boxName) {
        if (class_exists($boxName . 'Box')) {
            $objectClass = $boxName . 'Box';
            $object = new $objectClass();
            if ($object instanceof BlackBox) {
                $object->setId($this->generateId());
                return $object;
            }
        }

        throw new NotFoundBlackBoxException(sprintf('Попытка создвать BlackBox c не известным именем %s', $boxName));
    }

}

/**
 * Базовый класс для всех черных ящиков
 */
class BlackBox {

    protected $id;
    protected $labels = [
        'input',
        'output'
    ];

    function getId() {
        return $this->id;
    }

    function getLabels() {
        return $this->labels;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLabels($labels) {
        $this->labels = $labels;
    }

}

// исключения
class NotFoundBlackBoxException extends \Exception {
    
}

// НУЖНО ПЕРЕДЕЛАТЬ ЗАГРУЗКУ ОБЪЕКТОВ ПОД ТАКОЙ МАССИВ
$loadObjects = [
    'Start::1', // <-- Это и есть id
    'Const::1',
    'EqualConst::1',
    'If::1',
    'End::1'
];

$relationsLoad = [
    ['Start::1_output', 'If::1_input'],
    ['If::1_data', 'Const::1_output'],
    ['If::1_comparator', 'EqualConst::1_output'],
    ['If::1_output', 'End::1_inut'],
];

// тесты
$factory = new BlackBoxFactory();
$algorithm = new AlgorithmBox();


// функции временные
function writeln($message) {
    echo $message . "\n";
}
