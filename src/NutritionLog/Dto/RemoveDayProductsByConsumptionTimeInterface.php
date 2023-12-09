<?php

declare(strict_types=1);


namespace App\NutritionLog\Dto;

use App\NutritionLog\Value\ConsumptionTime;
use DateTimeInterface;

interface RemoveDayProductsByConsumptionTimeInterface
{
    public function getDay(): DateTimeInterface;

    public function getConsumptionTime(): ConsumptionTime;

    public function getUserId(): string;
}
