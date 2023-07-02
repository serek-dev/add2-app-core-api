<?php

namespace App\Tests\Product\Value;

use App\Product\Value\Weight;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

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
