<?php

namespace App\Tests\Diary\Entity;

use App\Diary\Entity\DayProduct;
use App\Diary\Value\ConsumptionTime;
use App\Diary\Value\ProductDetail;
use App\Diary\Value\Weight;
use App\Tests\Data\DiaryTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Diary\Entity\DayProduct */
final class DayProductTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new DayProduct(
            id: 'some-id',
            weight: new Weight(100.0),
            nutritionalValues: DiaryTestHelper::createNutritionValues(),
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
