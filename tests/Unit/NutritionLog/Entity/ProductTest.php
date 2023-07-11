<?php

namespace App\Tests\Unit\NutritionLog\Entity;

use App\NutritionLog\Entity\Product;
use App\NutritionLog\Value\Weight;
use App\Tests\Data\NutritionLogTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Value\ProductDetail */
final class ProductTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Product(
            'id',
            NutritionLogTestHelper::createNutritionValues(),
            'name',
            new Weight(100.0),
            null,
        );
        $this->assertInstanceOf(Product::class, $sut);
    }
}
