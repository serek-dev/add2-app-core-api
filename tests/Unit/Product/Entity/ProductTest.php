<?php

declare(strict_types=1);


namespace App\Tests\Unit\Product\Entity;


use App\Product\Entity\AggregateRoot;
use App\Product\Entity\Product;
use App\Shared\Event\ProductCreatedInterface;
use App\Tests\Data\TestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Entity\Product */
final class ProductTest extends TestCase
{
    public function testConstructor(): Product
    {
        $sut = new Product(
            uniqid(),
            TestHelper::createNutritionValues(),
            'Product name',
            'Producer'
        );

        $this->assertInstanceOf(Product::class, $sut);
        $this->assertInstanceOf(AggregateRoot::class, $sut);

        return $sut;
    }

    /** @depends testConstructor */
    public function testConstructorRecordProductCreatedEvent(Product $sut): void
    {
        $this->assertCount(1, $sut->pullEvents());
        $this->assertInstanceOf(ProductCreatedInterface::class, $sut->pullEvents()[0]);
    }

    public function testConstructorWithNoProducer(): void
    {
        $sut = new Product(
            uniqid(),
            TestHelper::createNutritionValues(),
            'Product name',
            null
        );

        $this->assertInstanceOf(Product::class, $sut);
    }
}
