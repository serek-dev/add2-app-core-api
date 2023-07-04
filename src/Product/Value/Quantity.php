<?php

declare(strict_types=1);


namespace App\Product\Value;


use App\Product\Entity\Product;

final class Quantity
{
    public function __construct(private readonly Weight $weight, private readonly Product $product)
    {
    }
}
