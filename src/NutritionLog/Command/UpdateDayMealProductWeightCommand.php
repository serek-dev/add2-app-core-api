<?php

declare(strict_types=1);

namespace App\NutritionLog\Command;

use App\NutritionLog\Dto\UpdateDayMealProductWeightDtoInterface;
use App\NutritionLog\Value\Weight;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class UpdateDayMealProductWeightCommand implements UpdateDayMealProductWeightDtoInterface
{
    public function __construct(
        private string $day,
        private string $mealId,
        private string $productId,
        private float  $weight,
        private string $userId,
    )
    {
    }

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->day);
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