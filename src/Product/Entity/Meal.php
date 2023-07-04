<?php

declare(strict_types=1);


namespace App\Product\Entity;


use App\Product\Value\Quantity;

final class Meal
{
    /**
     * @param Quantity[] $products
     */
    public function __construct(
        private readonly string $name,
        private readonly array $products,
    ) {
    }
}
