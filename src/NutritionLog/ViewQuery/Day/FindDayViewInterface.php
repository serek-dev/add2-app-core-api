<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\DayView;

interface FindDayViewInterface
{
    public function findDay(string $date): DayView;
}
