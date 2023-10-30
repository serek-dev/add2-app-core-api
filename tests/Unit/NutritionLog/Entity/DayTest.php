<?php

namespace App\Tests\Unit\NutritionLog\Entity;

use App\NutritionLog\Entity\Day;
use App\NutritionLog\Entity\DayMeal;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Value\ConsumptionTime;
use App\Tests\Data\NutritionLogTestHelper;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Entity\Day */
final class DayTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'));
        $this->assertInstanceOf(Day::class, $sut);
        $this->assertSame('2020-01-01', $sut->getDate());
    }

    public function testAddProduct(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'));
        $sut->addProduct(
            NutritionLogTestHelper::createDayProductEntity()
        );

        $this->assertCount(1, $sut->getProducts());
    }

    public function testAddMeal(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'));
        $sut->addMeal(
            new DayMeal(
                'id',
                'name',
                new ConsumptionTime('10:45'),
                []
            )
        );

        $this->assertCount(1, $sut->getMeals());
    }

    public function testRemoveMeal(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'));
        $sut->addMeal(
            new DayMeal(
                'id',
                'name',
                new ConsumptionTime('10:45'),
                []
            )
        );

        $sut->removeMeal('id');

        $this->assertCount(0, $sut->getMeals());
    }

    public function testRemoveMealExceptionOnNotFound(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Meal with id id2 not found');

        $sut = new Day(new DateTimeImmutable('2020-01-01'));

        $sut->removeMeal('id2');
    }
}
