<?php

declare(strict_types=1);


namespace App\Catalog\Builder;


use App\Catalog\Entity\Meal;
use App\Catalog\Entity\MealProduct;
use App\Catalog\Entity\Product;
use App\Catalog\Exception\DuplicateException;
use App\Catalog\Persistence\Meal\FindMealByNameInterface;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;

final class MealBuilder
{
    private ?string $id = null;
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
        return new Meal($this->id ?? uniqid('M-'), $name, $this->products);
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

    public function withId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
}
