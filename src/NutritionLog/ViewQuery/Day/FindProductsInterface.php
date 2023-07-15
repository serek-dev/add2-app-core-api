<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;

use App\Product\View\ProductView;

interface FindProductsInterface
{
    /**
     * @return ProductView[]
     */
    public function findProducts(string $date): array;
}
