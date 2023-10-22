<?php

declare(strict_types=1);


namespace App\Catalog\Persistence\Meal;

use App\Catalog\Entity\Meal;

interface FindMealByIdInterface
{
    public function findById(string $id): ?Meal;
}
