<?php

namespace App\Tests\Unit\NutritionLog\Factory;

use App\NutritionLog\Entity\Day;
use App\NutritionLog\Exception\DuplicateException;
use App\NutritionLog\Factory\DayFactory;
use App\NutritionLog\Factory\DayFactoryNutritionalTargetResolverInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Value\NutritionalTarget;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Factory\DayFactory */
final class DayFactoryTest extends TestCase
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

    public function testCreateThrowsExceptionOnExistingDay(): void
    {
        // Given I have a query that returns existing Day
        $query = $this->createMock(FindDayByDateInterface::class);
        $query->method('findDayByDate')
            ->willReturn(new Day(new DateTimeImmutable(), $this->target, 'user-id'));

        // And my factory
        $sut = new DayFactory($query, $this->createMock(DayFactoryNutritionalTargetResolverInterface::class));

        // Then show me an error
        $this->expectException(DuplicateException::class);

        // When trying to create
        $sut->create(new DateTimeImmutable(), 'user-id');
    }

    public function testCreate(): void
    {
        // Given I have a query that returns null
        $query = $this->createMock(FindDayByDateInterface::class);
        $query->method('findDayByDate')
            ->willReturn(null);

        // And my factory
        $resolver = $this->createMock(DayFactoryNutritionalTargetResolverInterface::class);
        $resolver->method('resolve')
            ->willReturn($this->target);
        $sut = new DayFactory($query, $resolver);

        // When trying to create
        $res = $sut->create($date = new DateTimeImmutable('2020-01-01'), 'user-id');

        // Then new Day should be created
        $this->assertEquals($date->format('Y-m-d'), $res->getDate());
    }
}
