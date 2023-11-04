<?php

declare(strict_types=1);

namespace App\NutritionLog\Dto;

use App\NutritionLog\Value\Weight;
use DateTimeInterface;

interface UpdateDayProductWeightDtoInterface
{
    public function getDay(): DateTimeInterface;

    public function getProductId(): string;

    public function getWeight(): Weight;
}