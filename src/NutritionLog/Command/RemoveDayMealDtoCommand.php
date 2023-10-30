<?php

declare(strict_types=1);

namespace App\NutritionLog\Command;

use App\NutritionLog\Dto\RemoveDayMealDtoInterface;
use DateTimeImmutable;
use DateTimeInterface;

final class RemoveDayMealDtoCommand implements RemoveDayMealDtoInterface
{
    public function __construct(
        private readonly string $day,
        private readonly string $mealId,
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
}