<?php

declare(strict_types=1);


namespace App\Product\Entity;


use App\Product\Value\NutritionalValues;

final class Product
{
    public function __construct(
        private readonly NutritionalValues $nutritionalValues,
        private readonly string $name,
        private readonly ?string $producerName
    ) {
    }
}
