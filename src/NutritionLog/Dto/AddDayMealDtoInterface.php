<?php

declare(strict_types=1);


namespace App\NutritionLog\Dto;

use App\NutritionLog\Value\ConsumptionTime;
use DateTimeInterface;

interface AddDayMealDtoInterface
{
    public function getDay(): DateTimeInterface;

    public function getConsumptionTime(): ConsumptionTime;

    public function getMealId(): string;
}
