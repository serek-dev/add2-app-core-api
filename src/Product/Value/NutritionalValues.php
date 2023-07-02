<?php

declare(strict_types=1);


namespace App\Product\Value;


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

    public function getProteins(): float
    {
        return $this->proteins->getRaw();
    }

    public function getFats(): float
    {
        return $this->fats->getRaw();
    }

    public function getCarbs(): float
    {
        return $this->carbs->getRaw();
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }
}
