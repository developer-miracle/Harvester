<?php

// Перечисление типа деревьев
enum TypeTree
{
    case apple;
    case pear;
}

// Перечисление типа плода
enum TypeFruit: string
{
    case apple = 'AppleFruit';
    case pear = 'PearFruit';
    case all = 'all';
}

// Перечисление заполнения дерева
enum Capacity
{
    case full;
    case empty;
}

// Интерфейс дерева
interface Tree
{
    function __construct();
    // Метод позволяет собрать плод
    function Harvest();
    // Метод позволяет выставить заполненость дерева плодами
    function SetCapacity(Capacity $capacity);
    // Метод возвращает заполненость дерева плодами
    function GetCapacity();
}

// Интерфейс плода
interface Fruit
{
    function __construct();
}

// класс плода яблони
class AppleFruit implements Fruit
{
    public $weight;
    function __construct()
    {
        $this->weight = rand(150, 180);
    }
}

// Класс плода груши
class PearFruit implements Fruit
{
    public $weight;
    function __construct()
    {
        $this->weight = rand(130, 170);
    }
}

// Класс дерева яблони
class AppleTree implements Tree
{
    public $id;
    public $capacity;
    function __construct()
    {
        $this->id = uniqid("appleTree");
        $this->capacity = true;
    }

    // Метод позволяет собрать плод
    public function Harvest()
    {
        if ($this->GetCapacity()) {
            $this->SetCapacity(Capacity::empty);
            $fruit = array();
            for ($i = 0; $i < rand(40, 50); $i++) {
                array_push($fruit, new AppleFruit());
            }
            return $fruit;
        } else return array();
    }

    // Метод позволяет выставить заполненость дерева плодами
    function SetCapacity(Capacity $capacity)
    {
        if ($capacity == Capacity::full) $this->capacity = true;
        else $this->capacity = false;
    }

    // Метод возвращает заполненость дерева плодами
    function GetCapacity()
    {
        return $this->capacity;
    }
}

// Класс дерева груши
class PearTree implements Tree
{
    public $id;
    public $capacity;
    function __construct()
    {
        $this->id = uniqid("pearTree");
        $this->capacity = true;
    }

    // Метод позволяет собрать плод
    public function Harvest()
    {
        if ($this->GetCapacity()) {
            $this->SetCapacity(Capacity::empty);
            $fruit = array();
            for ($i = 0; $i < rand(0, 20); $i++) {
                array_push($fruit, new PearFruit());
            }
            return $fruit;
        } else return array();
    }

    // Метод позволяет выставить заполненость дерева плодами
    public function SetCapacity(Capacity $capacity)
    {
        if ($capacity == Capacity::full) $this->capacity = true;
        else $this->capacity = false;
    }

    // Метод возвращает заполненость дерева плодами
    function GetCapacity()
    {
        return $this->capacity;
    }
}

// Класс сборщика
class Harvester
{
    public $trees = array();
    public $fruits = array();

    // Метод добавляет деревья в сад
    public function AddTree(TypeTree $type, $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            switch ($type) {
                case TypeTree::apple:
                    array_push($this->trees, new AppleTree());
                    break;
                case TypeTree::pear:
                    array_push($this->trees, new PearTree());
                    break;
            };
        }
    }

    // Метод производит сбор плодов
    public function Harvest(): void
    {
        foreach ($this->trees as $key => $value) {
            array_push($this->fruits, ...$value->Harvest());
        }
    }

    // Метод производит подсчет плодов по типу
    public function GetCountFruitByType(TypeFruit $type): int
    {
        switch ($type) {
            case TypeFruit::all:
                return count($this->fruits);
            case TypeFruit::apple:
            case TypeFruit::pear:
                $count = 0;
                foreach ($this->fruits as $key => $value) {
                    if (get_class($value) === $type->value) {
                        $count++;
                    }
                }
                return $count;
        }
    }

    // Метод производит подсчет веса плодов по типу
    public function GetWeightFruitByType(TypeFruit $type): float
    {
        switch ($type) {
            case TypeFruit::all:
                $weight = 0;
                foreach ($this->fruits as $key => $value) {
                    $weight += $value->weight;
                }
                return $weight;
            case TypeFruit::apple:
            case TypeFruit::pear:
                $weight = 0;
                foreach ($this->fruits as $key => $value) {
                    if (get_class($value) === $type->value) {
                        $weight += $value->weight;
                    }
                }
                return $weight;
        }
    }
}

$harvester = new Harvester();
$harvester->AddTree(TypeTree::apple, 10);
$harvester->AddTree(TypeTree::pear, 15);
$harvester->Harvest();
echo 'all fruit: ' . $harvester->GetCountFruitByType(TypeFruit::all) . PHP_EOL;
echo 'apple fruit: ' . $harvester->GetCountFruitByType(TypeFruit::apple) . PHP_EOL;
echo 'pear fruit: ' . $harvester->GetCountFruitByType(TypeFruit::pear) . PHP_EOL;
echo PHP_EOL;
echo 'weight all: ' . $harvester->GetWeightFruitByType(TypeFruit::all) / 1000 . 'kg' . PHP_EOL;
echo 'weight apple: ' . $harvester->GetWeightFruitByType(TypeFruit::apple) / 1000 . 'kg' . PHP_EOL;
echo 'weight pear: ' . $harvester->GetWeightFruitByType(TypeFruit::pear) / 1000 . 'kg' . PHP_EOL;
