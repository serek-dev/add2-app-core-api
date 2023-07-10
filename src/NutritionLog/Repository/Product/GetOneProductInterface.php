<?php

declare(strict_types=1);


namespace App\NutritionLog\Repository\Product;

use App\NutritionLog\Entity\Product;
use App\NutritionLog\Exception\NotFoundException;

interface GetOneProductInterface
{
    /**
     * @throws NotFoundException
     */
    public function getOne(string $productId): Product;
}
