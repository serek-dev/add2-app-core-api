<?php

namespace App\Tests\Unit\Catalog\Factory;

use App\Catalog\Command\CreateProductCommand;
use App\Catalog\Dto\CreateProductDtoInterface;
use App\Catalog\Entity\Product;
use App\Catalog\Exception\DuplicateException;
use App\Catalog\Exception\InvalidArgumentException;
use App\Catalog\Factory\ProductFactory;
use App\Catalog\Persistence\Product\FindProductByNameInterface;
use App\Catalog\Value\NutritionalValues;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Factory\ProductFactory */
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

    public function testCreateWithInvalidKcalSum(): void
    {
        // Given I have wrong sum kcal value

        $sut = new ProductFactory(
            $this->createMock(FindProductByNameInterface::class)
        );

        // Then I should be an invalid argument exception
        $this->expectException(InvalidArgumentException::class);

        // When I create new entity
        $sut->create(
            new CreateProductCommand(
                'Product',
                20.0,
                20.0,
                30.0,
                ((20 * 4) + (20 * 9) + (30 * 4)) * 2,
                '',
            )
        );
    }

    public function testCreateOnNonUniqueName(): void
    {
        // Given I have an existing product
        $findProductByName = $this->createMock(FindProductByNameInterface::class);
        $findProductByName
            ->method('findByName')
            ->with('name', 'product name')
            ->willReturn(ProductTestHelper::createProductEntity());

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
                return ProductTestHelper::createNutritionValues();
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
