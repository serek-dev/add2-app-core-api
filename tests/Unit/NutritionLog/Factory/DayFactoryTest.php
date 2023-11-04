<?php

namespace App\Tests\Unit\NutritionLog\Factory;

use App\NutritionLog\Entity\Day;
use App\NutritionLog\Exception\DuplicateException;
use App\NutritionLog\Factory\DayFactory;
use App\NutritionLog\Factory\NutritionalTargetResolver;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\Weight;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Factory\DayFactory */
final class DayFactoryTest extends TestCase
{
    private NutritionalValues $target;
    protected function setUp(): void
    {
        parent::setUp();
        $this->target = new NutritionalValues(
            new Weight(100),
            new Weight(100),
            new Weight(100),
            2500,
        );
    }
    public function testCreateThrowsExceptionOnExistingDay(): void
    {
        // Given I have a query that returns existing Day
        $query = $this->createMock(FindDayByDateInterface::class);
        $query->method('findDayByDate')
            ->willReturn(new Day(new DateTimeImmutable(), $this->target));

        // And my factory
        $sut = new DayFactory($query, new NutritionalTargetResolver());

        // Then show me an error
        $this->expectException(DuplicateException::class);

        // When trying to create
        $sut->create(new DateTimeImmutable());
    }

    public function testCreate(): void
    {
        // Given I have a query that returns null
        $query = $this->createMock(FindDayByDateInterface::class);
        $query->method('findDayByDate')
            ->willReturn(null);

        // And my factory
        $sut = new DayFactory($query, new NutritionalTargetResolver());

        // When trying to create
        $res = $sut->create($date = new DateTimeImmutable('2020-01-01'));

        // Then new Day should be created
        $this->assertEquals($date->format('Y-m-d'), $res->getDate());
    }
}
