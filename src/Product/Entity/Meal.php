<?php

declare(strict_types=1);


namespace App\Product\Entity;


final class Meal
{
    /**
     * @param MealProduct[] $products
     */
    public function __construct(
        private readonly string $name,
        private readonly array $products,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return MealProduct[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
