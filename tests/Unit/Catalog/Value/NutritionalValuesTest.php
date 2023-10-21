<?php

namespace App\Tests\Unit\Catalog\Value;

use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Value\NutritionalValues */
final class NutritionalValuesTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = ProductTestHelper::createNutritionValues();
        $this->assertInstanceOf(NutritionalValues::class, $sut);
    }

    public function testGetKcal(): void
    {
        $sut = ProductTestHelper::createNutritionValues();
        $this->assertSame(290.0, $sut->getKcal());
    }

    public function testGetters(): void
    {
        $sut = new NutritionalValues(new Weight(1), new Weight(2), new Weight(3), 100);
        $this->assertSame(1.0, $sut->getProteins());
        $this->assertSame(2.0, $sut->getFats());
        $this->assertSame(3.0, $sut->getCarbs());
    }
}
