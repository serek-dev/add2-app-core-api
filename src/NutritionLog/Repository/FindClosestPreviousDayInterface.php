<?php

namespace App\NutritionLog\Repository;

use App\NutritionLog\Entity\Day;
use DateTimeInterface;

interface FindClosestPreviousDayInterface
{
    public function findClosest(DateTimeInterface $dateTime, string $userId): ?Day;
}