<?php

namespace App\Tests\Unit\NutritionLog\Entity;

use App\NutritionLog\Entity\Day;
use App\NutritionLog\Entity\DayMeal;
use App\NutritionLog\Entity\DayProduct;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\NutritionalTarget;
use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\ProductDetail;
use App\NutritionLog\Value\Weight;
use App\Shared\Entity\AggregateRoot;
use App\Shared\Event\NutritionLogDayCreatedInterface;
use App\Shared\Event\NutritionLogDayTargetUpdatedInterface;
use App\Tests\Data\NutritionLogTestHelper;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Entity\Day */
final class DayTest extends TestCase
{
    private NutritionalTarget $target;

    protected function setUp(): void
    {
        parent::setUp();
        $this->target = new NutritionalTarget(
            0,
            0,
            0,
            0.0,
        );
    }

    public function testConstructor(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'), $this->target, 'user-id');

        $this->assertInstanceOf(AggregateRoot::class, $sut);
        $this->assertSame('2020-01-01', $sut->getDate());
    }

    public function testAddProduct(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'), $this->target, 'user-id');
        $sut->addProduct(
            NutritionLogTestHelper::createDayProductEntity()
        );

        $this->assertCount(1, $sut->getProducts());
    }

    public function testAddMeal(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'), $this->target, 'user-id');
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
        $sut = new Day(new DateTimeImmutable('2020-01-01'), $this->target, 'user-id');
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

        $sut = new Day(new DateTimeImmutable('2020-01-01'), $this->target, 'user-id');

        $sut->removeMeal('id2');
    }

    public function testRemoveProductExceptionOnNotFound(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Product with id id2 not found');

        $sut = new Day(new DateTimeImmutable('2020-01-01'), $this->target, 'user-id');

        $sut->removeProduct('id2');
    }

    public function testRemoveProduct(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'), $this->target, 'user-id');
        $sut->addProduct(
            new DayProduct(
                'id',
                new Weight(100),
                new NutritionalValues(
                    new Weight(100),
                    new Weight(100),
                    new Weight(100),
                    100,
                ),
                new ConsumptionTime('10:45'),
                new ProductDetail('name', 'description', 'image'),
            )
        );

        $dayProduct = $sut->removeProduct('id');

        $this->assertCount(0, $sut->getProducts());
        $this->assertInstanceOf(DayProduct::class, $dayProduct);
    }

    public function testConstructorShouldCreateEvent(): Day
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'), $this->target, 'user-id');

        $events = $sut->pullEvents();

        $this->assertCount(1, $events);

        $event = $events[0] ?? null;

        $this->assertInstanceOf(NutritionLogDayCreatedInterface::class, $event);
        $this->assertSame($this->target->getKcal(), $event->getKcalTarget());

        $this->assertEmpty($sut->pullEvents());

        return $sut;
    }

    /** @depends testConstructorShouldCreateEvent */
    public function testChangeTargetShouldCreateEvent(Day $sut): void
    {
        $sut->changeTarget(
            new NutritionalTarget(
                0,
                0,
                0,
                $newKcalTarget = 50.5,
            )
        );

        $events = $sut->pullEvents();

        $this->assertCount(1, $events);

        $event = $events[0] ?? null;

        $this->assertInstanceOf(NutritionLogDayTargetUpdatedInterface::class, $event);
        $this->assertSame($newKcalTarget, $event->getKcalTarget());
    }
}
