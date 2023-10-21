<?php

namespace App\Tests\Unit\Catalog\Command;

use App\Catalog\Command\CreateMealCommand;
use App\Catalog\Dto\CreateMealDtoInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Command\CreateMealCommand */
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
