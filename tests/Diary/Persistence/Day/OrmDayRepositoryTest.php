<?php

namespace App\Tests\Diary\Persistence\Day;

use App\Diary\Persistence\Day\FindDayByDateInterface;
use App\Diary\Persistence\Day\OrmDayRepository;
use App\Diary\Persistence\Day\StoreDayInterface;
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
