<?php

declare(strict_types=1);


namespace App\Catalog\Persistence\Product;

use App\Catalog\Entity\Product;

interface FindProductByIdInterface
{
    public function findById(string $id): ?Product;
}
