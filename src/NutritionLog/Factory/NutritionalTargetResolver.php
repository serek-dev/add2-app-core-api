<?php

declare(strict_types=1);

namespace App\NutritionLog\Factory;

use App\NutritionLog\Repository\FindClosestPreviousDayInterface;
use App\NutritionLog\Value\NutritionalTarget;
use DateTimeInterface;

final class NutritionalTargetResolver implements DayFactoryNutritionalTargetResolverInterface
{
    public function __construct(private readonly FindClosestPreviousDayInterface $day)
    {
    }

    public function resolve(DateTimeInterface $dateTime): NutritionalTarget
    {
        $null = new NutritionalTarget(
            0,
            0,
            0,
            0.0,
        );

        $day = $this->day->findClosest($dateTime);

        return $day ? $day->getTarget() : $null;
    }
}