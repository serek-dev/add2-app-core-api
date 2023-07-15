<?php

namespace App\Tests\Unit\Product\Command;

use App\Product\Command\CreateProductCommand;
use App\Product\Dto\CreateProductDtoInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Command\CreateProductCommand */
final class CreateProductCommandTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $sut = new CreateProductCommand(
            'name',
            1,
            2,
            3,
            10,
            'producer'
        );

        $this->assertInstanceOf(CreateProductDtoInterface::class, $sut);

        $this->assertEquals(1.0, $sut->getNutritionValues()->getProteins());
        $this->assertEquals(2.0, $sut->getNutritionValues()->getFats());
        $this->assertEquals(3.0, $sut->getNutritionValues()->getCarbs());
        $this->assertEquals(10.0, $sut->getNutritionValues()->getKcal());

        $this->assertSame('name', $sut->getName());
        $this->assertSame('producer', $sut->getProducerName());
    }
}
