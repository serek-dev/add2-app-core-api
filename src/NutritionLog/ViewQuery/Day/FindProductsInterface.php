<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\DayProductView;

interface FindProductsInterface
{
    /**
     * @return DayProductView[]
     */
    public function findProducts(string $date): array;
}
