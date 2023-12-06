<?php

namespace App\Catalog\Dto;

use App\Catalog\Value\Weight;

interface UpdateMealProductWeightDtoInterface
{
    public function getMealId(): string;

    public function getProductId(): string;

    public function getWeight(): Weight;

    public function getUserId(): string;
}