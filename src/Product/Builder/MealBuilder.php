<?php

declare(strict_types=1);


namespace App\Product\Builder;


use App\Product\Entity\Meal;
use App\Product\Entity\MealProduct;
use App\Product\Entity\Product;
use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;

final class MealBuilder
{
    private array $products = [];

    public function build(string $name): Meal
    {
        return new Meal(uniqid('M-'), $name, $this->products);
    }

    public function addProduct(Weight $quantity, Product $product): self
    {
        $productValues = $product->getNutritionValues();

        $divider = $quantity->getRaw() / 100; // grams

        $new = new NutritionalValues(
            new Weight($productValues->getProteins() * $divider),
            new Weight($productValues->getFats() * $divider),
            new Weight($productValues->getCarbs() * $divider),
            $productValues->getKcal() * $divider,
        );

        $this->products[] = new MealProduct(
            id: $product->getId(),
            nutritionalValues: $new,
            name: $product->getName(),
            parentId: $product->getId(),
            producerName: $product->getProducerName(),
        );

        return $this;
    }
}
