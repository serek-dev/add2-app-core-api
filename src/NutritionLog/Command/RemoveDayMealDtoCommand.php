<?php

declare(strict_types=1);

namespace App\NutritionLog\Command;

use App\NutritionLog\Dto\RemoveDayMealDtoInterface;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class RemoveDayMealDtoCommand implements RemoveDayMealDtoInterface
{
    public function __construct(
        private string $day,
        private string $mealId,
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

    public function getUserId(): string
    {
        return $this->userId;
    }
}