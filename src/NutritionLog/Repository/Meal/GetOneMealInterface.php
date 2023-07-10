<?php

declare(strict_types=1);


namespace App\NutritionLog\Repository\Meal;

use App\NutritionLog\Entity\Meal;
use App\NutritionLog\Exception\NotFoundException;

interface GetOneMealInterface
{
    /**
     * @throws NotFoundException
     */
    public function getOne(string $mealId): Meal;
}
