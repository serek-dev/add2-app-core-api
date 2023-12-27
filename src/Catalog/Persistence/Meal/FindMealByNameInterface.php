<?php

declare(strict_types=1);


namespace App\Catalog\Persistence\Meal;

use App\Catalog\Entity\Meal;

interface FindMealByNameInterface
{
    public function findByName(string $name, string $userId): ?Meal;
}
