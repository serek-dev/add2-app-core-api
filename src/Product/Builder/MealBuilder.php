<?php

declare(strict_types=1);


namespace App\Product\Builder;


use App\Product\Entity\Meal;
use App\Product\Entity\MealProduct;
use App\Product\Entity\Product;
use App\Product\Exception\DuplicateException;
use App\Product\Persistence\Meal\FindMealByNameInterface;
use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;

final class MealBuilder
{
    private array $products = [];

    public function __construct(private readonly FindMealByNameInterface $findMealByName)
    {
    }

    public function build(string $name, ?string $producerName = null): Meal
    {
        if ($this->findMealByName->findByName($name)) {
            throw new DuplicateException(
                "Meal with name: {$name} and produced by: {$producerName} already exist"
            );
        }
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
            id: uniqid('MP-'),
            weight: $quantity,
            nutritionalValues: $new,
            name: $product->getName(),
            parentId: $product->getId(),
            producerName: $product->getProducerName(),
        );

        return $this;
    }
}
