<?php

namespace App\Tests\Unit\Catalog\Handler;

use App\Catalog\Factory\ProductFactory;
use App\Catalog\Handler\CreateProductHandler;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Persistence\Product\FindProductByNameInterface;
use App\Catalog\Persistence\Product\ProductPersistenceInterface;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Handler\CreateProductHandler */
final class CreateProductHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given I have product factory
        $productFactory = new ProductFactory(
            $this->createMock(FindProductByNameInterface::class),
            $this->createMock(FindProductByIdInterface::class),
        );

        // Then it should be stored in a store
        $storeProduct = $this->createMock(ProductPersistenceInterface::class);
        $storeProduct->expects($this->once())
            ->method('store');

        // And product DTO
        $dto = ProductTestHelper::createCreateProductDto();

        // When I invoke my service
        $sut = new CreateProductHandler($productFactory, $storeProduct);
        $sut($dto);
    }
}
