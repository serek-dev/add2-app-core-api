<?php

declare(strict_types=1);


namespace App\Catalog\Persistence\Meal;

use App\Catalog\Entity\Meal;

interface MealPersistenceInterface
{
    public function store(Meal $meal): void;

    public function remove(Meal $meal): void;

    public function removeProduct(Meal $meal, string $productId);
}
