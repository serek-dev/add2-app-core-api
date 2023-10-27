<?php

namespace App\Tests\Unit\Catalog\Entity;

use App\Catalog\Entity\Meal;
use App\Catalog\Entity\MealProduct;
use App\Catalog\Exception\InvalidArgumentException;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;
use PHPUnit\Framework\TestCase;
use function iterator_to_array;

/** @covers \App\Catalog\Entity\Meal */
final class MealTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Meal('id', 'name', []);
        $this->assertInstanceOf(Meal::class, $sut);
    }

    public function testConstructorFailsOnNonMealProductData(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Meal('id', 'name', [$this]);
    }

    public function testRemoveAllProductsWhenNoArgs(): void
    {
        $sut = new Meal('id', 'name', [
            new MealProduct(
                'id',
                $w = new Weight(100.0),
                new NutritionalValues($w, $w, $w, 100),
                'name',
                'parentId',
                null,
            ),
            new MealProduct(
                'id2',
                $w = new Weight(100.0),
                new NutritionalValues($w, $w, $w, 100),
                'name',
                'parentId',
                null,
            ),
        ]);;
        $this->assertCount(2, iterator_to_array($sut->removeProducts()));
    }

    public function testRemoveJustOneProductWhenIdPassed(): void
    {
        $sut = new Meal('id', 'name', [
            new MealProduct(
                'id',
                $w = new Weight(100.0),
                new NutritionalValues($w, $w, $w, 100),
                'name',
                'parentId',
                null,
            ),
            new MealProduct(
                'id2',
                $w = new Weight(100.0),
                new NutritionalValues($w, $w, $w, 100),
                'name',
                'parentId',
                null,
            ),
        ]);;
        $this->assertCount(1, iterator_to_array($sut->removeProducts('id2')));
    }
}
