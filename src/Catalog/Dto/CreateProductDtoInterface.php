<?php

declare(strict_types=1);


namespace App\Catalog\Dto;

use App\Catalog\Value\NutritionalValues;

interface CreateProductDtoInterface
{
    public function getNutritionValues(): NutritionalValues;

    public function getName(): string;

    public function getProducerName(): ?string;
}