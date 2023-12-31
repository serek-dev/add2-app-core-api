<?php

declare(strict_types=1);


namespace App\Tests\Data;


use App\NutritionLog\Entity\DayProduct;
use App\NutritionLog\Entity\Product;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\ProductDetail;
use App\NutritionLog\Value\Weight;

final class NutritionLogTestHelper
{
    public static function createNutritionValues(): NutritionalValues
    {
        return new NutritionalValues(
            new Weight(20.0),
            new Weight(10.0),
            new Weight(30.0),
            80 + 90 + 120
        );
    }

    public static function createProductEntity(?string $id = null, ?string $name = null, ?NutritionalValues $values = null): Product
    {
        return new Product(
            $id ?? uniqid(),
            $values ?? self::createNutritionValues(),
            $name ?? 'Product name',
            'Producer',
        );
    }

    public static function createDayProductEntity(?string $id = null, ?string $name = null, ?NutritionalValues $values = null): DayProduct
    {
        return new DayProduct(
            $id ?? uniqid(),
            new Weight(100.0),
            $values ?? self::createNutritionValues(),
            new ConsumptionTime(rand(1, 10) . ':15'),
            new ProductDetail(
                '1',
                'org name',
                null,
            ),
        );
    }
}
