<?php

namespace App\Tests\Unit\NutritionLog\Persistence\Day;

use App\NutritionLog\Persistence\Day\DayPersistenceInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\OrmDayPersistenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Persistence\Day\OrmDayPersistenceRepository */
final class OrmDayRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new OrmDayPersistenceRepository($this->createMock(EntityManagerInterface::class));
        $this->assertInstanceOf(FindDayByDateInterface::class, $sut);
        $this->assertInstanceOf(DayPersistenceInterface::class, $sut);
    }
}
