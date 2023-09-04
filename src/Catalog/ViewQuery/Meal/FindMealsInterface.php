<?php

declare(strict_types=1);


namespace App\Catalog\ViewQuery\Meal;

use App\Catalog\View\MealView;

interface FindMealsInterface
{
    /**
     * @return MealView[]
     */
    public function findAll(?string $name = null): array;
}
