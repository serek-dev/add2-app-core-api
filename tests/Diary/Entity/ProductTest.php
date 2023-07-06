<?php

namespace App\Tests\Diary\Entity;

use App\Diary\Entity\Product;
use App\Tests\Data\DiaryTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Diary\Value\ProductDetail */
final class ProductTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Product(
            'id',
            DiaryTestHelper::createNutritionValues(),
            'name',
            null,
        );
        $this->assertInstanceOf(Product::class, $sut);
    }
}
