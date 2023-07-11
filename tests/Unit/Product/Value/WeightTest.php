<?php

namespace App\Tests\Unit\Product\Value;

use App\Product\Value\Weight;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Value\Weight */
final class WeightTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Weight(100);
        $this->assertInstanceOf(Weight::class, $sut);
    }

    public function testConstructorValueNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Weight(-1);
    }
}
