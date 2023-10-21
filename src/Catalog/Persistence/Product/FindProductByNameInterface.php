<?php

declare(strict_types=1);


namespace App\Catalog\Persistence\Product;

use App\Catalog\Entity\Product;

interface FindProductByNameInterface
{
    public function findByName(string $productName, ?string $producerName = null): ?Product;
}
