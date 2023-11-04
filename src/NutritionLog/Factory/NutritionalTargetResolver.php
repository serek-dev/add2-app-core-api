<?php

declare(strict_types=1);

namespace App\NutritionLog\Factory;

use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\Weight;
use DateTimeInterface;

final class NutritionalTargetResolver implements DayFactoryNutritionalTargetResolverInterface
{

    public function resolve(DateTimeInterface $dateTime): NutritionalValues
    {
        return new NutritionalValues(
            new Weight(100),
            new Weight(100),
            new Weight(100),
            2500,
        );
    }
}