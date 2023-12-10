<?php

declare(strict_types=1);


namespace App\NutritionLog\Dto;

use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\Weight;
use DateTimeInterface;

interface AddDayProductDtoInterface
{
    public function getDay(): DateTimeInterface;

    public function getConsumptionTime(): ConsumptionTime;

    public function getProductId(): string;

    public function getUserId(): string;

    public function getProductWeight(): Weight;
}
