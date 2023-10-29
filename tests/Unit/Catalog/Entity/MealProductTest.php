<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog\Entity;

use App\Catalog\Entity\MealProduct;
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
            weight: new Weight(100.0),
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
                'weight' => new Weight(200.0),
            ],
            [
                'expected' => new NutritionalValues(
                    new Weight(5.0),
                    new Weight(5.0),
                    new Weight(5.0),
                    85.0,
                ),
                'weight' => new Weight(50.0),
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
}
