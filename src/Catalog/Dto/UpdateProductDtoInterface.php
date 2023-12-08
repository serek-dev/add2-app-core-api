<?php

declare(strict_types=1);


namespace App\Catalog\Dto;

use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Portion;

interface UpdateProductDtoInterface
{
    public function getNutritionValues(): NutritionalValues;

    public function getName(): string;

    public function getId(): string;

    public function getProducerName(): ?string;

    public function getPortion(): ?Portion;

    public function getUserId(): string;
}
