<?php

declare(strict_types=1);


namespace App\Tests\Data;


use App\Diary\Entity\Product;
use App\Diary\Value\NutritionalValues;
use App\Diary\Value\Weight;

final class DiaryTestHelper
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
}
