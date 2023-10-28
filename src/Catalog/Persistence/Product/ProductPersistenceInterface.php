<?php

declare(strict_types=1);


namespace App\Catalog\Persistence\Product;

use App\Catalog\Entity\Product;

interface ProductPersistenceInterface
{
    public function store(Product ...$product): void;

    public function remove(Product $product): void;
}
