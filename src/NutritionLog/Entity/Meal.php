<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Exception\InvalidArgumentException;

final class Meal
{
    /**
     * @param Product[] $products
     */
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly array $products = [],
    ) {
        foreach ($products as $p) {
            if (!$p instanceof Product) {
                throw new InvalidArgumentException('Argument must be a: ' . Product::class . ' instance');
            }
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @return Product[] */
    public function getProducts(): array
    {
        return $this->products;
    }
}
