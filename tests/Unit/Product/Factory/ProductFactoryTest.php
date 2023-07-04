<?php

namespace App\Tests\Unit\Product\Factory;

use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Entity\Product;
use App\Product\Exception\DuplicateException;
use App\Product\Factory\ProductFactory;
use App\Product\Persistence\Product\FindProductByNameInterface;
use App\Product\Value\NutritionalValues;
use App\Tests\Data\TestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Factory\ProductFactory */
final class ProductFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $sut = new ProductFactory(
            $this->createMock(FindProductByNameInterface::class)
        );

        $actual = $sut->create($this->getDto());

        $this->assertInstanceOf(Product::class, $actual);
    }

    public function testCreateOnNonUniqueName(): void
    {
        // Given I have an existing product
        $findProductByName = $this->createMock(FindProductByNameInterface::class);
        $findProductByName
            ->method('findByName')
            ->with('name', 'product name')
            ->willReturn(TestHelper::createProductEntity());

        // And my factory
        $sut = new ProductFactory($findProductByName);

        // Then I should see a duplicate exception
        $this->expectException(DuplicateException::class);

        // When I create a new entity
        $sut->create($this->getDto());
    }

    private function getDto(): CreateProductDtoInterface
    {
        return new class() implements CreateProductDtoInterface {

            public function getNutritionValues(): NutritionalValues
            {
                return TestHelper::createNutritionValues();
            }

            public function getName(): string
            {
                return 'name';
            }

            public function getProducerName(): ?string
            {
                return 'product name';
            }
        };
    }
}
