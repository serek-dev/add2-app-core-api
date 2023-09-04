<?php

namespace App\Tests\Unit\Catalog\Entity;

use App\Catalog\Entity\Meal;
use App\Catalog\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

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
}
