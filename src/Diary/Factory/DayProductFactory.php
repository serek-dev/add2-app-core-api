<?php

declare(strict_types=1);


namespace App\Diary\Factory;


use App\Diary\Entity\DayProduct;
use App\Diary\Entity\Product;
use App\Diary\Value\ConsumptionTime;
use App\Diary\Value\NutritionalValues;
use App\Diary\Value\ProductDetail;
use App\Diary\Value\Weight;

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
            ),
        );
    }
}
