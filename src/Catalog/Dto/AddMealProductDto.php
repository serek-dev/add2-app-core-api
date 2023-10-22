<?php

namespace App\Catalog\Dto;

use App\Catalog\Value\Weight;

interface AddMealProductDto
{
    public function getMealId(): string;

    public function getProductId(): string;

    public function getWeight(): Weight;
}