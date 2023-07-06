<?php

namespace App\Tests\Diary\Entity;

use App\Diary\Entity\Day;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\Diary\Entity\Day */
final class DayTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'));
        $this->assertInstanceOf(Day::class, $sut);
    }
}
