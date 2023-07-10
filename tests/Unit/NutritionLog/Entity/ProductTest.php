<?php

namespace App\Tests\Unit\NutritionLog\Entity;

use App\NutritionLog\Entity\Product;
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
            null,
        );
        $this->assertInstanceOf(Product::class, $sut);
    }
}
