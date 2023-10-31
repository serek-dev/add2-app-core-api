<?php

namespace App\Tests\Unit\Catalog\Command;

use App\Catalog\Command\CreateProductCommand;
use App\Catalog\Dto\CreateProductDtoInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Command\CreateProductCommand */
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
            'producer',
            null,
            null,
            null,
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
