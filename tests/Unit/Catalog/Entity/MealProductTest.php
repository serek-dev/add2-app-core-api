<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog\Entity;

use App\Catalog\Entity\MealProduct;
use App\Catalog\Entity\Product;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Entity\MealProduct */
final class MealProductTest extends TestCase
{
    /** @dataProvider providerForChangeWeight */
    public function testChangeWeight(NutritionalValues $expected, Weight $weight): void
    {
        $mealProduct = new MealProduct(
            id: 'id',
            weight: new Weight(50.0),
            nutritionalValues: new NutritionalValues(
                new Weight(10.0),
                new Weight(10.0),
                new Weight(10.0),
                170.0,
            ),
            name: 'name',
            parentId: 'parentId',
            producerName: 'producerName',
        );

        $mealProduct->changeWeight($weight);

        $this->assertEquals($mealProduct->getNutritionValues(), $expected);
    }

    public function providerForChangeWeight(): array
    {
        return [
            [
                'expected' => new NutritionalValues(
                    new Weight(20.0),
                    new Weight(20.0),
                    new Weight(20.0),
                    340.0,
                ),
                'weight' => new Weight(100.0),
            ],
            [
                'expected' => new NutritionalValues(
                    new Weight(10.0),
                    new Weight(10.0),
                    new Weight(10.0),
                    170.0,
                ),
                'weight' => new Weight(50.0),
            ],
            [
                'expected' => new NutritionalValues(
                    new Weight(5.0),
                    new Weight(5.0),
                    new Weight(5.0),
                    85.0,
                ),
                'weight' => new Weight(25.0),
            ],
            [
                'expected' => new NutritionalValues(
                    new Weight(0.0),
                    new Weight(0.0),
                    new Weight(0.0),
                    0.0,
                ),
                'weight' => new Weight(0.0),
            ],
        ];
    }

    public function testReplaceByProduct(): void
    {
        $mealProduct = new MealProduct(
            id: 'id-1',
            weight: new Weight(50.0),
            nutritionalValues: new NutritionalValues(
                new Weight(10.0),
                new Weight(10.0),
                new Weight(10.0),
                170.0,
            ),
            name: 'name-1',
            parentId: 'parentId-1',
            producerName: 'producerName-1',
        );

        $product = new Product(
            'prg-product',
            nutritionalValues: new NutritionalValues(
                new Weight(20.0),
                new Weight(20.0),
                new Weight(20.0),
                340.0,
            ),
            name: 'name-2',
            producerName: 'producerName-2',
        );

        $mealProduct->replaceByProduct($product);

        $this->assertSame('id-1', $mealProduct->getId());
        $this->assertSame('name-2', $mealProduct->getName());
        $this->assertSame('producerName-2', $mealProduct->getProducerName());
        $this->assertSame('prg-product', $mealProduct->getParentId());

        $this->assertEquals(new Weight(50.0), $mealProduct->getWeight());
    }
}
