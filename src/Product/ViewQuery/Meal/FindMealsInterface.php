<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Meal;

use App\Product\View\MealView;

interface FindMealsInterface
{
    /**
     * @return MealView[]
     */
    public function findAll(?string $name = null): array;
}
