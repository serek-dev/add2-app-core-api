<?php

declare(strict_types=1);


namespace App\Tests\Data;


use App\Product\Value\NutritionalValues;

final class TestHelper
{
    public static function createNutritionValues(): NutritionalValues
    {
        return new NutritionalValues(20, 10, 30);
    }
}
