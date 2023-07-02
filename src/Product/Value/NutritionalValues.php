<?php

declare(strict_types=1);


namespace App\Product\Value;


use InvalidArgumentException;

/**
 * Per 100g of product
 */
final class NutritionalValues
{
    public function __construct(
        private readonly float $proteins,
        private readonly float $fats,
        private readonly float $carbs,
    ) {
        foreach (func_get_args() as $value) {
            if ($value < 0) {
                throw new InvalidArgumentException('Value should not be less than 0');
            }
        }
    }

    public function getProteins(): float
    {
        return $this->proteins;
    }

    public function getFats(): float
    {
        return $this->fats;
    }

    public function getCarbs(): float
    {
        return $this->carbs;
    }
}
