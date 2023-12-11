<?php

declare(strict_types=1);


namespace App\NutritionLog\Dto;

use DateTimeInterface;

interface RemoveDayMealDtoInterface
{
    public function getDay(): DateTimeInterface;

    public function getMealId(): string;

    public function getUserId(): string;
}
