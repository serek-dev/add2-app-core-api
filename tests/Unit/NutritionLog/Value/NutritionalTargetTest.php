<?php

declare(strict_types=1);

namespace App\Tests\Unit\NutritionLog\Value;

use App\NutritionLog\Value\NutritionalTarget;
use DomainException;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Value\NutritionalTarget */
final class NutritionalTargetTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $kcalSum = (1 * 4) + (2 * 9) + (3 * 4);
        $sut = new NutritionalTarget(
            proteins: 25,
            fats: 25,
            carbs: 50,
            kcal: $kcalSum,
        );

        self::assertSame(25, $sut->getProteins());
        self::assertSame(25, $sut->getFats());
        self::assertSame(50, $sut->getCarbs());
        self::assertEquals($kcalSum, $sut->getKcal());
    }

    public function testConstructorWithEmpty(): void
    {
        $sut = new NutritionalTarget(
            proteins: 0,
            fats: 0,
            carbs: 0,
            kcal: 0.0,
        );

        self::assertSame(0, $sut->getProteins());
        self::assertSame(0, $sut->getFats());
        self::assertSame(0, $sut->getCarbs());
        self::assertSame(0.0, $sut->getKcal());
    }

    public function testConstructorThrowsExceptionWhenPercentageSumIsNot100(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Nutritional target percentage sum must be 100');

        $sut = new NutritionalTarget(
            proteins: 20,
            fats: 10,
            carbs: 30,
            kcal: 0.0,
        );
    }
}
