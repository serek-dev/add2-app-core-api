<?php

declare(strict_types=1);


namespace App\NutritionLog\Persistence\Day;

use App\NutritionLog\Entity\Day;

interface DayPersistenceInterface
{
    public function store(Day $day): void;
}
