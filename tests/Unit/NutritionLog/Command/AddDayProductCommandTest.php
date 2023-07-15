<?php

namespace App\Tests\Unit\NutritionLog\Command;

use App\NutritionLog\Command\AddDayProductCommand;
use App\NutritionLog\Dto\AddDayProductDtoInterface;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\Weight;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Command\AddDayProductCommand */
final class AddDayProductCommandTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $sut = new AddDayProductCommand(
            date: '2020-01-01',
            consumptionTime: '10:45',
            productId: 'product-id',
            productWeight: 10.0
        );

        $this->assertInstanceOf(AddDayProductDtoInterface::class, $sut);

        $this->assertEquals(
            new DateTimeImmutable('2020-01-01'),
            $sut->getDay(),
        );

        $this->assertEquals(
            new ConsumptionTime('10:45'),
            $sut->getConsumptionTime(),
        );

        $this->assertSame('product-id', $sut->getProductId());

        $this->assertEquals(
            new Weight(10.0),
            $sut->getProductWeight(),
        );
    }
}
