<?php

declare(strict_types=1);


namespace App\Catalog\ViewQuery\Meal;

use App\Catalog\View\MealView;

interface FindMealViewsInterface
{
    /**
     * @return MealView[]
     */
    public function findAll(?string $userId = null, ?string $name = null): array;
}
