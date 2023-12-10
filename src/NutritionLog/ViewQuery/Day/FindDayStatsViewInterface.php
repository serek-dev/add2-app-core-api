<?php

namespace App\NutritionLog\ViewQuery\Day;

use App\NutritionLog\View\DayStatsView;
use DateTimeInterface;

interface FindDayStatsViewInterface
{
    /** @return DayStatsView[] */
    public function findStats(DateTimeInterface $from, DateTimeInterface $to, string $userId): array;
}