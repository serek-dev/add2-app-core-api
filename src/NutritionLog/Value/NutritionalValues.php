<?php

declare(strict_types=1);


namespace App\NutritionLog\Value;


/**
 * Per 100g of product
 */
final class NutritionalValues
{
    public function __construct(
        private readonly Weight $proteins,
        private readonly Weight $fats,
        private readonly Weight $carbs,
        private readonly float $kcal,
    ) {
    }

    public function getProteins(): Weight
    {
        return $this->proteins;
    }

    public function getFats(): Weight
    {
        return $this->fats;
    }

    public function getCarbs(): Weight
    {
        return $this->carbs;
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }
}
