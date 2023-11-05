<?php

declare(strict_types=1);


namespace App\Tests\Unit\NutritionLog\Handler;


use App\NutritionLog\Command\RemoveDayProductsByConsumptionTimeCommand;
use App\NutritionLog\Entity\Day;
use App\NutritionLog\Entity\DayMeal;
use App\NutritionLog\Entity\DayProduct;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Handler\RemoveProductsByConsumptionTimeHandler;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\OrmDayPersistenceRepository;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\NutritionalTarget;
use App\Tests\Data\DayProductTestHelper;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

final class RemoveProductsByConsumptionTimeHandlerTest extends TestCase
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

    public function testThrowsNotFoundOnNonExistingDay(): void
    {
        $sut = new RemoveProductsByConsumptionTimeHandler(
            $this->createMock(FindDayByDateInterface::class),
            $this->createMock(RemoveInterface::class),
        );

        $command = new RemoveDayProductsByConsumptionTimeCommand('2020-01-01', '10:00');

        $this->expectException(NotFoundException::class);

        $sut($command);
    }

    public function testThrowsNotFoundOnNonExistingMealAtGivenTime(): void
    {
        // Given I have a valid day
        $day = new Day(new DateTimeImmutable(), $this->target);
        $day->addProduct(DayProductTestHelper::createDayProductEntity('10:45'));

        // And the query that returns it
        $findByDate = $this->createMock(FindDayByDateInterface::class);
        $findByDate->method('findDayByDate')
            ->willReturn($day);

        $sut = new RemoveProductsByConsumptionTimeHandler($findByDate, $this->createMock(RemoveInterface::class));

        $command = new RemoveDayProductsByConsumptionTimeCommand('2020-01-01', '10:00');

        $this->expectException(NotFoundException::class);

        $sut($command);
    }

    public function testRemovesAllProductsAndMeals(): void
    {
        // Given I have a valid day with two products
        $day = new Day(new DateTimeImmutable(), $this->target);
        $day->addProduct(DayProductTestHelper::createDayProductEntity('10:45'));
        $day->addProduct(DayProductTestHelper::createDayProductEntity('10:45'));

        // And 1 meal
        $day->addMeal(DayProductTestHelper::createDayMealEntity('10:45'));

        // And one product from another consumption time
        $day->addProduct(DayProductTestHelper::createDayProductEntity('12:00'));

        // And the query that returns it
        $findByDate = $this->createMock(FindDayByDateInterface::class);
        $findByDate->method('findDayByDate')
            ->willReturn($day);

        // When I attempt to remove it by consumption time
        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('flush');
        $sut = new RemoveProductsByConsumptionTimeHandler($findByDate, new OrmDayPersistenceRepository($em));

        $command = new RemoveDayProductsByConsumptionTimeCommand('2020-01-01', '10:45');

        $sut($command);

        // Then there should not be any products & meals inside
        $this->assertEmpty(array_filter($day->getProducts(), fn(DayProduct $p) => $p->getConsumptionTime()->equals($command->getConsumptionTime())));
        $this->assertEmpty(array_filter($day->getMeals(), fn(DayMeal $p) => $p->getConsumptionTime()->equals($command->getConsumptionTime())));

        // But products from another time should remain untouched
        $this->assertNotEmpty(array_filter($day->getProducts(), fn(DayProduct $p) => $p->getConsumptionTime()->equals(new ConsumptionTime('12:00'))));
    }
}
