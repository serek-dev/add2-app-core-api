<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\ProductView;

interface FindProductsInterface
{
    /**
     * @return ProductView[]
     */
    public function findProducts(string $date): array;
}
