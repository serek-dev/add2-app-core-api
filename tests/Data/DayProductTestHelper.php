<?php

declare(strict_types=1);


namespace App\Tests\Data;


use App\NutritionLog\Entity\DayMeal;
use App\NutritionLog\Entity\DayMealProduct;
use App\NutritionLog\Entity\DayProduct;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\ProductDetail;
use App\NutritionLog\Value\Weight;

final class DayProductTestHelper
{
    public static function createDayProductEntity(string $time): DayProduct
    {
        return new DayProduct(
            uniqid(),
            new Weight(100),
            new NutritionalValues(new Weight(10.0), new Weight(10.0), new Weight(10.0), 170.0),
            new ConsumptionTime($time),
            new ProductDetail(
                uniqid(),
                'Something fake',
                null,
            )
        );
    }

    public static function createDayMealProductEntity(): DayMealProduct
    {
        return new DayMealProduct(
            uniqid(),
            new Weight(100),
            new NutritionalValues(new Weight(10.0), new Weight(10.0), new Weight(10.0), 170.0),
            new ProductDetail(
                uniqid(),
                'Something fake',
                null,
            )
        );
    }

    public static function createDayMealEntity(string $time): DayMeal
    {
        return new DayMeal(
            uniqid(),
            'Fake meal',
            new ConsumptionTime($time),
            [
                self::createDayMealProductEntity(),
                self::createDayMealProductEntity(),
            ]
        );
    }
}
