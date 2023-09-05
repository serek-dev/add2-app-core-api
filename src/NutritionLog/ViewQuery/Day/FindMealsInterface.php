<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\DayMealView;
use App\NutritionLog\View\DayProductView;

interface FindMealsInterface
{
    /** @return DayMealView[] */
    public function findMeals(string $date): array;

    /** @return DayProductView[] */
    public function findMealProducts(string $mealId): array;
}
