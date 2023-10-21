<?php

declare(strict_types=1);


namespace App\Catalog\Persistence\Product;

use App\Catalog\Entity\Product;

interface StoreProductInterface
{
    public function store(Product $product): void;
}
