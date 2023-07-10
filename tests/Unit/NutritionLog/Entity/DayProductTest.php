<?php

namespace App\Tests\Unit\NutritionLog\Entity;

use App\NutritionLog\Entity\DayProduct;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\ProductDetail;
use App\NutritionLog\Value\Weight;
use App\Tests\Data\NutritionLogTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Entity\DayProduct */
final class DayProductTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new DayProduct(
            id: 'some-id',
            weight: new Weight(100.0),
            nutritionalValues: NutritionLogTestHelper::createNutritionValues(),
            consumptionTime: new ConsumptionTime('10:45'),
            original: new ProductDetail(
                'id',
                'name',
                'producer'
            ),
        );

        $this->assertInstanceOf(DayProduct::class, $sut);
    }
}
