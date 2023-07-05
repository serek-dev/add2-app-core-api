<?php

declare(strict_types=1);


namespace App\Product\Persistence\Product;

use App\Product\Entity\Product;

interface FindProductByIdInterface
{
    public function findById(string $id): ?Product;
}
