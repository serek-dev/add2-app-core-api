<?php

namespace App\Tests\Unit\Product\Command;

use App\Product\Command\CreateMealCommand;
use App\Product\Dto\CreateMealDtoInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Command\CreateMealCommand */
final class CreateMealCommandTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $sut = new CreateMealCommand(
            'name', $products = [
            ['id' => 'productId', 'weight' => 10.5],
        ]
        );

        $this->assertInstanceOf(CreateMealDtoInterface::class, $sut);

        $this->assertSame('name', $sut->getName());
        $this->assertEquals($products, $sut->getProducts());
    }
}
