<?php

namespace App\Tests\Product\Handler;

use App\Product\Builder\MealBuilder;
use App\Product\Command\CreateMealCommand;
use App\Product\Handler\CreateMealHandler;
use App\Product\Persistence\Meal\StoreMealInterface;
use App\Product\Persistence\Product\FindProductByIdInterface;
use App\Tests\Data\TestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Handler\CreateMealHandler */
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
            ->willReturn($product = TestHelper::createProductEntity());

        // Then newly created entity should be perissted
        $storeMeal = $this->createMock(StoreMealInterface::class);
        $storeMeal->expects($this->once())
            ->method('store');

        // When I attempt to create it
        $sut = new CreateMealHandler(
            new MealBuilder(),
            $findProductById,
            $storeMeal,
        );

        $sut($dto);
    }
}
