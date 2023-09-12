<?php

declare(strict_types=1);


namespace App\NutritionLog\Persistence\Day;

use App\NutritionLog\Entity\Day;
use App\NutritionLog\Value\ConsumptionTime;

interface RemoveInterface
{
    public function removeProductsAndMeals(Day $day, ConsumptionTime $time): void;
}