<?php

namespace App\Tests\Unit\NutritionLog\Command;

use App\NutritionLog\Command\AddDayMealCommand;
use App\NutritionLog\Dto\AddDayMealDtoInterface;
use App\NutritionLog\Value\ConsumptionTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Command\AddDayMealCommand */
final class AddDayMealCommandTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $sut = new AddDayMealCommand(
            date: '2020-01-01',
            consumptionTime: '10:45',
            mealId: 'meal-id',
            userId: 'user-id',
        );

        $this->assertInstanceOf(AddDayMealDtoInterface::class, $sut);

        $this->assertEquals(
            new DateTimeImmutable('2020-01-01'),
            $sut->getDay(),
        );

        $this->assertEquals(
            new ConsumptionTime('10:45'),
            $sut->getConsumptionTime(),
        );

        $this->assertSame('meal-id', $sut->getMealId());
        $this->assertSame('user-id', $sut->getUserId());
    }
}
