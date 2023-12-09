<?php

declare(strict_types=1);

namespace App\NutritionLog\Factory;

use App\NutritionLog\Value\NutritionalTarget;
use DateTimeInterface;

interface DayFactoryNutritionalTargetResolverInterface
{
    public function resolve(DateTimeInterface $dateTime, string $userId): NutritionalTarget;
}