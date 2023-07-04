<?php

namespace App\Tests\Product\Value;

use App\Product\Value\Quantity;
use App\Product\Value\Weight;
use App\Tests\Data\TestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Value\Quantity */
final class QuantityTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Quantity(
            new Weight(100),
            TestHelper::createProductEntity(),
        );

        $this->assertInstanceOf(Quantity::class, $sut);
    }
}
