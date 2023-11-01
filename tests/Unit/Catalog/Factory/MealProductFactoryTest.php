<?php

declare(strict_types=1);

namespace Catalog\Factory;

use App\Catalog\Entity\MealProduct;
use App\Catalog\Entity\Product;
use App\Catalog\Factory\MealProductFactory;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Portion;
use App\Catalog\Value\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Factory\MealProductFactory */
final class MealProductFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        // Create a mock Product with NutritionalValues and other properties
        $product = $this->createMock(Product::class);
        $product->method('getName')->willReturn('Test Product');
        $product->method('getId')->willReturn('P123');
        $product->method('getProducerName')->willReturn('Producer X');
        $productValues = new NutritionalValues(new Weight(10.0), new Weight(5.0), new Weight(15.0), 200.0);
        $product->method('getNutritionValues')->willReturn($productValues);
        $product->method('getPortion')->willReturn(new Portion('szt.', 50));

        // Create a Weight object
        $quantity = new Weight(200.0);

        // Create the MealProductFactory
        $factory = new MealProductFactory();

        // Call the create method
        $mealProduct = $factory->create($product, $quantity);

        // Assertions
        $this->assertInstanceOf(MealProduct::class, $mealProduct);
        $this->assertStringStartsWith('MP-', $mealProduct->getId()); // Check if id starts with 'MP-'
        $this->assertEquals($quantity, $mealProduct->getWeight());
        $this->assertEquals($product->getName(), $mealProduct->getName());
        $this->assertEquals($product->getProducerName(), $mealProduct->getProducerName());

        // Check nutritional values by calculating them
        $expectedNutritionalValues = new NutritionalValues(
            new Weight(20.0),
            new Weight(10.0),
            new Weight(30.0),
            400.0
        );

        $this->assertEquals($expectedNutritionalValues, $mealProduct->getNutritionValues());

        $this->assertEquals($product->getPortion(), $mealProduct->getPortion());
    }
}
