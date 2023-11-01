<?php

namespace App\Catalog\Factory;

use App\Catalog\Entity\MealProduct;
use App\Catalog\Entity\Product;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;

final class MealProductFactory
{
    public function create(Product $product, Weight $quantity): MealProduct
    {
        $productValues = $product->getNutritionValues();

        $divider = $quantity->getRaw() / 100; // grams

        $new = new NutritionalValues(
            new Weight($productValues->getProteins() * $divider),
            new Weight($productValues->getFats() * $divider),
            new Weight($productValues->getCarbs() * $divider),
            $productValues->getKcal() * $divider,
        );

        return new MealProduct(
            id: uniqid('MP-'),
            weight: $quantity,
            nutritionalValues: $new,
            name: $product->getName(),
            parentId: $product->getId(),
            producerName: $product->getProducerName(),
            portion: $product->getPortion(),
        );
    }
}