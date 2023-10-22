<?php

declare(strict_types=1);


namespace App\Catalog\Command;


use App\Catalog\Dto\AddMealProductDto;
use App\Catalog\Value\Weight;

final class AddMealProductCommand implements AddMealProductDto
{
    public function __construct(
        private readonly string $mealId,
        private readonly string $productId,
        private readonly float  $weight,
    )
    {
    }

    public function getMealId(): string
    {
        return $this->mealId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getWeight(): Weight
    {
        return new Weight($this->weight);
    }
}
