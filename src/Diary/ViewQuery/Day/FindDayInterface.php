<?php

declare(strict_types=1);


namespace App\Diary\ViewQuery\Day;

use App\Diary\View\DayView;

interface FindDayInterface
{
    public function findDay(string $date): DayView;
}
