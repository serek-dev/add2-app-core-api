<?php

declare(strict_types=1);

namespace Catalog\Handler;

use App\Catalog\Command\AddMealProductCommand;
use App\Catalog\Dto\AddMealProductDto;
use App\Catalog\Entity\Meal;
use App\Catalog\Entity\Product;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Factory\MealProductFactory;
use App\Catalog\Handler\AddMealProductHandler;
use App\Catalog\Persistence\Meal\FindMealByIdInterface;
use App\Catalog\Persistence\Meal\MealPersistenceInterface;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Handler\AddMealProductHandler */
final class AddMealProductHandlerTest extends TestCase
{
    public function testProductNotFoundException(): void
    {
        // Create a mock FindProductByIdInterface that returns null
        $findProductById = $this->createMock(FindProductByIdInterface::class);
        $findProductById->method('findById')->willReturn(null);

        // Create the handler with the mocked FindProductByIdInterface
        $handler = new AddMealProductHandler(
            $this->createMock(FindMealByIdInterface::class),
            $findProductById,
            new MealProductFactory(),
            $this->createMock(MealPersistenceInterface::class)
        );

        // Create a mock AddMealProductDto
        $dto = $this->createMock(AddMealProductDto::class);
        $dto->method('getProductId')->willReturn('someProductId');

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Product: someProductId does not exist');

        // Call the handler
        $handler($dto);
    }

    public function testMealNotFoundException(): void
    {
        // Create a mock FindProductByIdInterface that returns a mock Product
        $findProductById = $this->createMock(FindProductByIdInterface::class);
        $findProductById->method('findById')->willReturn($this->getProduct());

        // Create a mock FindMealByIdInterface that returns null
        $findMealById = $this->createMock(FindMealByIdInterface::class);
        $findMealById->method('findById')->willReturn(null);

        // Create the handler with the mocked FindProductByIdInterface and FindMealByIdInterface
        $handler = new AddMealProductHandler(
            $findMealById,
            $findProductById,
            new MealProductFactory(),
            $this->createMock(MealPersistenceInterface::class)
        );

        // Create a mock AddMealProductDto
        $dto = $this->createMock(AddMealProductDto::class);
        $dto->method('getMealId')->willReturn('someMealId');

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Meal: someMealId does not exist');

        // Call the handler
        $handler($dto);
    }

    public function testProductAddedToMeal(): void
    {
        $sut = new Meal(id: 'M123', name: 'Test Meal', userId: 'U123', products: []);
        $product = $this->getProduct();

        // Create a mock FindProductByIdInterface that returns a mock Product
        $findProductById = $this->createMock(FindProductByIdInterface::class);
        $findProductById->method('findById')->willReturn($product);

        // Create a mock FindMealByIdInterface that returns a mock Meal
        $findMealById = $this->createMock(FindMealByIdInterface::class);
        $findMealById->method('findById')->willReturn($sut);

        // Create a mock MealProductFactory that returns a mock MealProduct
        $mealProductFactory = new MealProductFactory();

        // Create a mock StoreMealInterface
        $storeMeal = $this->createMock(MealPersistenceInterface::class);
        $storeMeal->expects($this->once())->method('store');

        // Create the handler with the mocked dependencies
        $handler = new AddMealProductHandler($findMealById, $findProductById, $mealProductFactory, $storeMeal);

        // Create a mock AddMealProductDto
        $dto = new AddMealProductCommand(
            mealId: 'M123',
            productId: 'P123',
            weight: 150.0);

        $handler($dto);

        $this->assertCount(1, $sut->getProducts());
    }

    public function getProduct(): Product
    {
        return new Product(
            id: 'P123',
            nutritionalValues: new NutritionalValues(
                proteins: new Weight(10.0),
                fats: new Weight(5.0),
                carbs: new Weight(15.0),
                kcal: 200.0,
            ),
            userId: 'user-id',
            name: 'Test Product',
            producerName: 'Producer X',
        );
    }
}
