<?php

namespace App\Tests\Unit\Catalog\Builder;

use App\Catalog\Builder\MealBuilder;
use App\Catalog\Entity\Meal;
use App\Catalog\Exception\DuplicateException;
use App\Catalog\Persistence\Meal\FindMealByNameInterface;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Builder\MealBuilder */
final class MealBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $sut = new MealBuilder($this->createMock(FindMealByNameInterface::class));

        $actual = $sut->build('name');

        $this->assertInstanceOf(Meal::class, $actual);
        $this->assertSame('name', $actual->getName());

        $this->assertStringStartsWith('M-', $actual->getId());
    }

    public function testBuildThrowsDuplicate(): void
    {
        $mealByName = $this->createMock(FindMealByNameInterface::class);
        $meal = new Meal('id', 'name', []);
        $mealByName->method('findByName')->willReturn($meal);

        $sut = new MealBuilder($mealByName);

        $this->expectException(DuplicateException::class);

        $sut->build('name');
    }

    public function testBuildWithProducts(): MealBuilder
    {
        // Given I have my builder
        $sut = new MealBuilder($this->createMock(FindMealByNameInterface::class));

        // And products I want to add in
        $product1 = ProductTestHelper::createProductEntity(
            id: '1',
            name: 'Product 1',
            values: new NutritionalValues(
                new Weight(20.0),
                new Weight(10.0),
                new Weight(30.0),
                290.0
            ),
        );

        // When I add 50g of it
        $sut->addProduct(
            new Weight(50.0),
            $product1,
        );

        // And I build meal
        $actual = $sut->build('name');

        // Then there new meal product should be created
        $this->assertCount(1, $actual->getProducts());

        // And it's nutrition values should be half of the original values
        $first = $actual->getProducts()[0]->getNutritionValues();
        $this->assertSame(10.0, $first->getProteins());
        $this->assertSame(5.0, $first->getFats());
        $this->assertSame(15.0, $first->getCarbs());
        $this->assertSame(290.0 / 2, $first->getKcal());

        return clone $sut;
    }

    /** @depends testBuildWithProducts */
    public function testBuildWithMultipleProducts(MealBuilder $sut): void
    {
        // When I add another product in amount of 200 g
        $sut->addProduct(
            new Weight(200.0),
            ProductTestHelper::createProductEntity(
                id: '2',
                name: 'Product 2',
                values: new NutritionalValues(
                    new Weight(20.0),
                    new Weight(10.0),
                    new Weight(30.0),
                    290.0
                ),
            ),
        );

        // And I build meal
        $actual = $sut->build('name');

        // Then there new meal product should be created
        $this->assertCount(2, $actual->getProducts());

        // And it's nutrition values should be 2x of the original values
        $second = $actual->getProducts()[1]->getNutritionValues();
        $this->assertSame(40.0, $second->getProteins());
        $this->assertSame(20.0, $second->getFats());
        $this->assertSame(60.0, $second->getCarbs());
        $this->assertSame(290.0 * 2, $second->getKcal());
    }
}
