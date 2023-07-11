<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\MealProductView;
use App\NutritionLog\View\MealView;

interface FindMealsInterface
{
    /** @return MealView[] */
    public function findMeals(string $date): array;

    /** @return MealProductView[] */
    public function findMealProducts(string $mealId): array;
}
