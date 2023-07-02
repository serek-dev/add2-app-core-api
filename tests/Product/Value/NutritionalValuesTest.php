<?php

namespace App\Tests\Product\Value;

use App\Product\Value\NutritionalValues;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Value\NutritionalValues */
final class NutritionalValuesTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new NutritionalValues(0, 0, 0);
        $this->assertInstanceOf(NutritionalValues::class, $sut);
    }

    public function testConstructorFailsAtNegativeProteins(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NutritionalValues(-1, 0, 0);
    }

    public function testConstructorFailsAtNegativeFats(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NutritionalValues(0, -1, 0);
    }

    public function testConstructorFailsAtNegativeCarbs(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NutritionalValues(0, 0, -1);
    }
}
