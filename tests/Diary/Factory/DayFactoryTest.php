<?php

namespace App\Tests\Diary\Factory;

use App\Diary\Entity\Day;
use App\Diary\Exception\DuplicateException;
use App\Diary\Factory\DayFactory;
use App\Diary\Persistence\Day\FindDayByDateInterface;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\Diary\Factory\DayFactory */
final class DayFactoryTest extends TestCase
{
    public function testCreateThrowsExceptionOnExistingDay(): void
    {
        // Given I have a query that returns existing Day
        $query = $this->createMock(FindDayByDateInterface::class);
        $query->method('findDayByDate')
            ->willReturn(new Day(new DateTimeImmutable()));

        // And my factory
        $sut = new DayFactory($query);

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
        $sut = new DayFactory($query);

        // When trying to create
        $res = $sut->create($date = new DateTimeImmutable('2020-01-01'));

        // Then new Day should be created
        $this->assertEquals($date->format('Y-m-d'), $res->getDate());
    }
}
