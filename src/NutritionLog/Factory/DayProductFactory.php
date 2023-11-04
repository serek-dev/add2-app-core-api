<?php

declare(strict_types=1);


namespace App\NutritionLog\Factory;


use App\NutritionLog\Entity\DayProduct;
use App\NutritionLog\Entity\Product;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\ProductDetail;
use App\NutritionLog\Value\Weight;

// todo: missing test
final class DayProductFactory
{
    public function create(
        ConsumptionTime $consumptionTime,
        Product $product,
        Weight $quantity
    ): DayProduct {
        $productValues = $product->getNutritionValues();

        $divider = $quantity->getRaw() / 100; // grams

        $new = new NutritionalValues(
            new Weight($productValues->getProteins()->getRaw() * $divider),
            new Weight($productValues->getFats()->getRaw() * $divider),
            new Weight($productValues->getCarbs()->getRaw() * $divider),
            $productValues->getKcal() * $divider,
        );

        return new DayProduct(
            uniqid('DP-'),
            $quantity,
            $new,
            $consumptionTime,
            new ProductDetail(
                $product->getId(),
                $product->getName(),
                $product->getProducerName(),
                $product->getPortion(),
            ),
        );
    }
}
