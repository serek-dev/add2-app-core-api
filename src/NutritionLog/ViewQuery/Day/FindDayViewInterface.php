<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\DayView;

interface FindDayViewInterface
{
    public function findByDateAndUser(string $date, string $userId): DayView;
}
