<?php

declare(strict_types=1);


namespace App\Tests\Data;


use App\Product\Command\CreateProductCommand;
use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Entity\Product;
use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;

final class TestHelper
{
    public static function createNutritionValues(): NutritionalValues
    {
        return new NutritionalValues(
            new Weight(20.0),
            new Weight(10.0),
            new Weight(30.0),
            (20 * 4) + (20 * 9) + (30 * 4)
        );
    }

    public static function createProductEntity(): Product
    {
        return new Product(
            self::createNutritionValues(),
            'Product name',
            'Producer',
        );
    }

    public static function createCreateProductDto(): CreateProductDtoInterface
    {
        return new CreateProductCommand(
            'name',
            20.0,
            10.0,
            30.0,
            (20 * 4) + (20 * 9) + (30 * 4),
            'Producer'
        );
    }
}