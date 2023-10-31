<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog\Handler;


use App\Catalog\Command\UpdateProductCommand;
use App\Catalog\Dto\UpdateProductDtoInterface;
use App\Catalog\Entity\Product;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Handler\UpdateProductHandler;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Persistence\Product\ProductPersistenceInterface;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Handler\UpdateProductHandler */
final class UpdateProductHandlerTest extends TestCase
{
    private FindProductByIdInterface $findProductMock;
    private ProductPersistenceInterface $storeProductMock;

    protected function setUp(): void
    {
        $this->findProductMock = $this->createMock(FindProductByIdInterface::class);
        $this->storeProductMock = $this->createMock(ProductPersistenceInterface::class);
    }

    public function testUpdateProductHandlerWithValidData(): void
    {
        $product = new Product(
            'id-1',
            ProductTestHelper::createNutritionValues(),
            'Product name',
            'Producer'
        );

        $updateProductDto = new UpdateProductCommand(
            id: 'id-1',
            name: 'Updated Product',
            proteins: 1,
            fats: 1,
            carbs: 1,
            kcal: 17,
            producerName: 'Updated Producer',
            unit: 'g',
            weightPerUnit: 1,
        );

        $handler = new UpdateProductHandler($this->findProductMock, $this->storeProductMock);

        $this->findProductMock->method('findById')->with('id-1')->willReturn($product);

        $this->storeProductMock->expects($this->once())->method('store')->with($product)
            ->willReturnCallback(function (Product $p): void {
                $this->assertSame('Updated Product', $p->getName());
                $this->assertSame('Updated Producer', $p->getProducerName());
                $this->assertEquals(
                    new NutritionalValues(
                        new Weight(1),
                        new Weight(1),
                        new Weight(1),
                        17,
                    ),
                    $p->getNutritionValues(),
                );
            });

        $handler($updateProductDto);
    }

    public function testUpdateProductHandlerWithNotFoundProduct()
    {
        $productId = '1';

        $updateProductDto = $this->createMock(UpdateProductDtoInterface::class);
        $updateProductDto->method('getId')->willReturn($productId);

        $handler = new UpdateProductHandler($this->findProductMock, $this->storeProductMock);

        $this->findProductMock->method('findById')->with($productId)->willReturn(null);

        $this->expectException(NotFoundException::class);
        $handler($updateProductDto);
    }
}
