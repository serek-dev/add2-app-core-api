<?php

declare(strict_types=1);


namespace App\NutritionLog\Repository\Product;

use App\NutritionLog\Entity\Product;

interface FindAllProductsInterface
{
    /**
     * @return Product[]
     */
    public function findAll(): array;
}
