<?php

namespace App\Tests\Product\Factory;

use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Entity\Product;
use App\Product\Factory\ProductFactory;
use App\Product\Value\NutritionalValues;
use App\Tests\Data\TestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Factory\ProductFactory */
final class ProductFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $sut = new ProductFactory();

        $actual = $sut->create($this->getDto());

        $this->assertInstanceOf(Product::class, $actual);
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

            public function getProducerName(): string
            {
                return 'product name';
            }
        };
    }
}
