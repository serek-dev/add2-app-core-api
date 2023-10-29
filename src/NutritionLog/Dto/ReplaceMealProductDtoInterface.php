<?php

namespace App\NutritionLog\Dto;

use DateTimeInterface;

interface ReplaceMealProductDtoInterface
{
    public function getDay(): DateTimeInterface;

    public function getMealId(): string;

    public function getProductId(): string;

    public function getNewProductId(): string;
}