<?php

declare(strict_types=1);


namespace App\Product\Persistence\Product;

use App\Product\Entity\Product;

interface FindProductByNameInterface
{
    public function findByName(string $productName, ?string $producerName = null): ?Product;
}
