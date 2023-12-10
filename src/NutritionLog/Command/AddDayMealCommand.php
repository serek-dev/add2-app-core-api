<?php

declare(strict_types=1);


namespace App\NutritionLog\Command;


use App\NutritionLog\Dto\AddDayMealDtoInterface;
use App\NutritionLog\Value\ConsumptionTime;
use DateTimeImmutable;
use DateTimeInterface;

final class AddDayMealCommand implements AddDayMealDtoInterface
{
    public function __construct(
        private readonly string $date,
        private readonly string $consumptionTime,
        private readonly string $mealId,
        private readonly string $userId,
    ) {
    }

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->date);
    }

    public function getConsumptionTime(): ConsumptionTime
    {
        return new ConsumptionTime($this->consumptionTime);
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
