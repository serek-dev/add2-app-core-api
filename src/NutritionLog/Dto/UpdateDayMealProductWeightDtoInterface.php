<?php

declare(strict_types=1);

namespace App\NutritionLog\Dto;

use App\NutritionLog\Value\Weight;
use DateTimeInterface;

interface UpdateDayMealProductWeightDtoInterface
{
    public function getDay(): DateTimeInterface;

    public function getMealId(): string;

    public function getProductId(): string;

    public function getWeight(): Weight;
}