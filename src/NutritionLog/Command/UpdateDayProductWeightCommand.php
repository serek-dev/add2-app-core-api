<?php

declare(strict_types=1);

namespace App\NutritionLog\Command;

use App\NutritionLog\Dto\UpdateDayProductWeightDtoInterface;
use App\NutritionLog\Value\Weight;
use DateTimeImmutable;
use DateTimeInterface;

final class UpdateDayProductWeightCommand implements UpdateDayProductWeightDtoInterface
{
    public function __construct(
        private readonly string $day,
        private readonly string $productId,
        private readonly float  $weight,
    )
    {
    }

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->day);
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