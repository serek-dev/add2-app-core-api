<?php

declare(strict_types=1);


namespace App\Product\Dto;

use App\Product\Value\NutritionalValues;

interface CreateProductDtoInterface
{
    public function getNutritionValues(): NutritionalValues;

    public function getName(): string;

    public function getProducerName(): string;
}
