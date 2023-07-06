<?php

declare(strict_types=1);


namespace App\Diary\Persistence\Day;

use App\Diary\Entity\Day;

interface StoreDayInterface
{
    public function store(Day $day): void;
}
