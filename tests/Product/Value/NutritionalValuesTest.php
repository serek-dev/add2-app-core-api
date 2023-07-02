<?php

namespace App\Tests\Product\Value;

use App\Product\Value\NutritionalValues;
use App\Tests\Data\TestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\Value\NutritionalValues */
final class NutritionalValuesTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = TestHelper::createNutritionValues();
        $this->assertInstanceOf(NutritionalValues::class, $sut);
    }

    public function testGetKcal(): void
    {
        $sut = TestHelper::createNutritionValues();
        $this->assertSame(380.0, $sut->getKcal());
    }
}
