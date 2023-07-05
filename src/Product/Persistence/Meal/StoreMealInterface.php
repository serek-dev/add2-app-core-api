<?php

declare(strict_types=1);


namespace App\Product\Persistence\Meal;

use App\Product\Entity\Meal;

interface StoreMealInterface
{
    public function store(Meal $meal): void;
}