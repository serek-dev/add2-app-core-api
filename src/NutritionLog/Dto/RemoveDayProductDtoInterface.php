<?php

declare(strict_types=1);


namespace App\NutritionLog\Dto;

use DateTimeInterface;

interface RemoveDayProductDtoInterface
{
    public function getDay(): DateTimeInterface;

    public function getProductId(): string;

    public function getUserId(): string;
}
