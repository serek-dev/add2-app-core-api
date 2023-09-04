<?php

namespace App\Tests\Unit\Catalog\Handler;

use App\Catalog\Builder\MealBuilder;
use App\Catalog\Command\CreateMealCommand;
use App\Catalog\Handler\CreateMealHandler;
use App\Catalog\Persistence\Meal\FindMealByNameInterface;
use App\Catalog\Persistence\Meal\StoreMealInterface;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Handler\CreateMealHandler */
final class CreateMealHandlerTest extends TestCase
{
    public function testInvokeWithValidProducts(): void
    {
        // Given I have a dto request
        $dto = new CreateMealCommand('name', [
            [
                'id' => 'product-1',
                'weight' => 100.0
            ]
        ]);

        // And all requested products exist
        $findProductById = $this->createMock(FindProductByIdInterface::class);
        $findProductById->expects($this->once())
            ->method('findById')
            ->with('product-1')
            ->willReturn($product = ProductTestHelper::createProductEntity());

        // Then newly created entity should be perissted
        $storeMeal = $this->createMock(StoreMealInterface::class);
        $storeMeal->expects($this->once())
            ->method('store');

        // When I attempt to create it
        $sut = new CreateMealHandler(
            new MealBuilder(
                $this->createMock(FindMealByNameInterface::class),
            ),
            $findProductById,
            $storeMeal,
        );

        $sut($dto);
    }
}
