<?php

declare(strict_types=1);


namespace App\NutritionLog\Persistence\Day;

use App\NutritionLog\Entity\Day;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Value\ConsumptionTime;

interface RemoveInterface
{
    public function removeProductsAndMeals(Day $day, ConsumptionTime $time): void;

    /**
     * @throws NotFoundException
     */
    public function removeMealProduct(Day $day, string $mealProductId): void;

    /**
     * @throws NotFoundException
     */
    public function removeMeal(Day $day, string $mealId): void;

    /**
     * @throws NotFoundException
     */
    public function removeProduct(Day $day, string $productId): void;
}
