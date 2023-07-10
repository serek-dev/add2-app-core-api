<?php

namespace App\Tests\Unit\NutritionLog\Persistence\Day;

use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\OrmDayRepository;
use App\NutritionLog\Persistence\Day\StoreDayInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

final class OrmDayRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new OrmDayRepository($this->createMock(EntityManagerInterface::class));
        $this->assertInstanceOf(FindDayByDateInterface::class, $sut);
        $this->assertInstanceOf(StoreDayInterface::class, $sut);
    }
}
