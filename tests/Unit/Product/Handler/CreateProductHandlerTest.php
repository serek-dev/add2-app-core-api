<?php

namespace App\Tests\Product\Handler;

use App\Product\Factory\ProductFactory;
use App\Product\Handler\CreateProductHandler;
use App\Product\Repository\Product\FindProductByNameInterface;
use App\Product\Repository\Product\StoreProductInterface;
use App\Tests\Data\TestHelper;
use PHPUnit\Framework\TestCase;

final class CreateProductHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given I have product factory
        $productFactory = new ProductFactory(
            $this->createMock(FindProductByNameInterface::class)
        );

        // Then it should be stored in a store
        $storeProduct = $this->createMock(StoreProductInterface::class);
        $storeProduct->expects($this->once())
            ->method('store');

        // And product DTO
        $dto = TestHelper::createCreateProductDto();

        // When I invoke my service
        $sut = new CreateProductHandler($productFactory, $storeProduct);
        $sut($dto);
    }
}
