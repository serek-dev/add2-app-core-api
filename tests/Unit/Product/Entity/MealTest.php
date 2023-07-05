<?php

namespace App\Tests\Unit\Product\Entity;

use App\Product\Entity\Meal;
use App\Product\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Entity\Meal */
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
}
