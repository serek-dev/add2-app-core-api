<?php

declare(strict_types=1);


namespace App\NutritionLog\Dto;

use DateTimeInterface;

interface RemoveDayMealProductInterface
{
    public function getDay(): DateTimeInterface;

    public function getProductId(): string;

    public function getUserId(): string;
}
