<?php

namespace App\Tests\Unit\Product\Value;

use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;
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

    public function testGetters(): void
    {
        $sut = new NutritionalValues(new Weight(1), new Weight(2), new Weight(3), 100);
        $this->assertSame(1.0, $sut->getProteins());
        $this->assertSame(2.0, $sut->getFats());
        $this->assertSame(3.0, $sut->getCarbs());
    }
}
