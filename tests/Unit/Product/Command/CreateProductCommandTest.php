<?php

namespace App\Tests\Unit\Product\Command;

use App\Product\Command\CreateProductCommand;
use App\Product\Dto\CreateProductDtoInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Command\CreateProductCommand */
final class CreateProductCommandTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new CreateProductCommand(
            'name',
            1,
            2,
            3,
            10,
            null
        );

        $this->assertInstanceOf(CreateProductDtoInterface::class, $sut);
    }
}
