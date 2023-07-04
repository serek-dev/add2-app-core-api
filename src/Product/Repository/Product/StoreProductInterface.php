<?php

declare(strict_types=1);


namespace App\Product\Repository\Product;

use App\Product\Entity\Product;

interface StoreProductInterface
{
    public function store(Product $product): void;
}
