<?php

declare(strict_types=1);


namespace App\NutritionLog\Persistence\Day;

use App\NutritionLog\Entity\Day;
use DateTimeInterface;

interface FindDayByDateInterface
{
    public function findDayByDate(DateTimeInterface $date): ?Day;
}
