<?php

namespace App\Tests\Unit\NutritionLog\Entity;

use App\NutritionLog\Entity\Day;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Entity\Day */
final class DayTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Day(new DateTimeImmutable('2020-01-01'));
        $this->assertInstanceOf(Day::class, $sut);
    }
}
