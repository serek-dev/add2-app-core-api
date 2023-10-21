<?php

declare(strict_types=1);


namespace App\Tests\Unit\Catalog\Entity;


use App\Catalog\Entity\Product;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Entity\Product */
final class ProductTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Product(
            uniqid(),
            ProductTestHelper::createNutritionValues(),
            'Product name',
            'Producer'
        );

        $this->assertInstanceOf(Product::class, $sut);
    }

    public function testConstructorWithNoProducer(): void
    {
        $sut = new Product(
            uniqid(),
            ProductTestHelper::createNutritionValues(),
            'Product name',
            null
        );

        $this->assertInstanceOf(Product::class, $sut);
    }
}
