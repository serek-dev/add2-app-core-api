<?php

declare(strict_types=1);


namespace App\Catalog\Command;


use App\Catalog\Dto\UpdateMealProductWeightDtoInterface;
use App\Catalog\Value\Weight;

final readonly class UpdateMealProductWeightWeightCommand implements UpdateMealProductWeightDtoInterface
{
    public function __construct(
        private string $mealId,
        private string $productId,
        private float  $weight,
        private string $userId,
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

    public function getUserId(): string
    {
        return $this->userId;
    }
}
