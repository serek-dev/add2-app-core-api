<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\MealView;
use App\NutritionLog\View\ProductView;

interface FindMealsInterface
{
    /** @return MealView[] */
    public function findMeals(string $date): array;

    /** @return ProductView[] */
    public function findMealProducts(string $mealId): array;
}
