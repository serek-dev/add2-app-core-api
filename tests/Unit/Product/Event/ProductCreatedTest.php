<?php

namespace App\Tests\Unit\Product\Event;

use App\Product\Event\ProductCreated;
use App\Shared\Event\ProductCreatedInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Event\ProductCreated */
final class ProductCreatedTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new ProductCreated(
            '',
            '',
            0.0,
            0.0,
            0.0,
            0.0,
            null,
        );

        $this->assertInstanceOf(ProductCreatedInterface::class, $sut);
    }
}
