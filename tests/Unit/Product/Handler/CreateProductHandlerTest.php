<?php

namespace App\Tests\Unit\Product\Handler;

use App\Product\Factory\ProductFactory;
use App\Product\Handler\CreateProductHandler;
use App\Product\Persistence\Product\FindProductByNameInterface;
use App\Product\Persistence\Product\StoreProductInterface;
use App\Shared\Event\ProductCreatedInterface;
use App\Tests\Data\TestHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

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

        // And queue that should be used to trigger created event
        $externalQueue = $this->createMock(MessageBusInterface::class);
        $externalQueue->expects($this->once())
            ->method('dispatch')
            ->willReturnCallback(function (object $e) {
                $this->assertInstanceOf(ProductCreatedInterface::class, $e);
                return new Envelope($e);
            });

        // And product DTO
        $dto = TestHelper::createCreateProductDto();

        // When I invoke my service
        $sut = new CreateProductHandler($productFactory, $storeProduct, $externalQueue);
        $sut($dto);
    }
}
