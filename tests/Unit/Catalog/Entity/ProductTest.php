<?php

declare(strict_types=1);


namespace App\Tests\Unit\Catalog\Entity;


use App\Catalog\Entity\Product;
use App\Catalog\Value\Portion;
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
            'user-id',
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
            'user-id',
            'Product name',
            null
        );

        $this->assertInstanceOf(Product::class, $sut);
    }

    public function testPortion(): void
    {
        $sut = new Product(
            uniqid(),
            ProductTestHelper::createNutritionValues(),
            'user-id',
            'Product name',
            'Producer'
        );

        $sut->setPortion(new Portion('szt', 50));

        $this->assertSame('szt', $sut->getPortion()->getUnit());
        $this->assertSame(50, $sut->getPortion()->getWeightPerUnit());
    }
}
