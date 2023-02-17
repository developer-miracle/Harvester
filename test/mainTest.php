<?php

use PHPUnit\Framework\TestCase;

require __DIR__ . "../../src/main.php";

class mainTest extends TestCase
{
    // Тест проверяет метод добавления дерева
    public function testAddTree(): void
    {
        $harvester = new Harvester();
        $result = $harvester->trees;
        $this->assertIsArray($result);
        $this->assertEmpty($result);
        $harvester->AddTree(TypeTree::apple, 10);
        $result = $harvester->trees;
        $this->assertCount(10, $result);
        $harvester->AddTree(TypeTree::pear, 15);
        $result = $harvester->trees;
        $this->assertCount(25, $result);

        for ($i = 0; $i < count($result); $i++) {
            $this->assertInstanceOf(Tree::class, $result[$i]);
        }
    }

    // Тест проверяет метод сбора плодов
    public function testHarvest(): void
    {
        $harvester = new Harvester();
        $harvester->AddTree(TypeTree::apple, 1);
        $harvester->AddTree(TypeTree::pear, 1);
        $result = $harvester->fruits;
        $this->assertEmpty($result);
        $harvester->Harvest();
        $result = $harvester->fruits;
        $this->assertNotEmpty($result);
        for ($i = 0; $i < count($result); $i++) {
            $this->assertInstanceOf(Fruit::class, $result[$i]);
        }
    }

    // Тест проверяет метод подсчета собраных плодов по типу
    public function testGetCountFruitByType(): void
    {
        $harvester = new Harvester();
        $harvester->AddTree(TypeTree::apple, 10);
        $harvester->AddTree(TypeTree::pear, 15);
        $result = $harvester->GetCountFruitByType(TypeFruit::all);
        $this->assertIsInt($result);
        $this->assertEquals(0, $result);
        $result = $harvester->GetCountFruitByType(TypeFruit::apple);
        $this->assertEquals(0, $result);
        $result = $harvester->GetCountFruitByType(TypeFruit::pear);
        $this->assertEquals(0, $result);
        $harvester->Harvest();
        $result = $harvester->GetCountFruitByType(TypeFruit::all);
        $this->assertGreaterThan(0, $result);
        $result = $harvester->GetCountFruitByType(TypeFruit::apple);
        $this->assertGreaterThan(0, $result);
        $result = $harvester->GetCountFruitByType(TypeFruit::pear);
        $this->assertGreaterThan(0, $result);
    }

    // Тест проверяет метод подсчета веса собраных плодов по типу
    public function testGetWeightFruitByType(): void
    {
        $harvester = new Harvester();
        $harvester->AddTree(TypeTree::apple, 10);
        $harvester->AddTree(TypeTree::pear, 15);
        $result = $harvester->GetWeightFruitByType(TypeFruit::all);
        $this->assertIsFloat($result);
        $this->assertEquals(0, $result);
        $result = $harvester->GetWeightFruitByType(TypeFruit::apple);
        $this->assertEquals(0, $result);
        $result = $harvester->GetWeightFruitByType(TypeFruit::pear);
        $this->assertEquals(0, $result);
        $harvester->Harvest();
        $result = $harvester->GetWeightFruitByType(TypeFruit::all);
        $this->assertGreaterThan(0, $result);
        $result = $harvester->GetWeightFruitByType(TypeFruit::apple);
        $this->assertGreaterThan(0, $result);
        $result = $harvester->GetWeightFruitByType(TypeFruit::pear);
        $this->assertGreaterThan(0, $result);
    }
}
