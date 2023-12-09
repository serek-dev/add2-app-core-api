<?php

declare(strict_types=1);


namespace App\NutritionLog\Factory;


use App\NutritionLog\Entity\Day;
use App\NutritionLog\Exception\DuplicateException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use DateTimeInterface;

final class DayFactory
{
    public function __construct(
        private readonly FindDayByDateInterface                       $findDayByDate,
        private readonly DayFactoryNutritionalTargetResolverInterface $resolver,
    )
    {
    }

    public function create(DateTimeInterface $dateTime, string $userId): Day
    {
        if ($this->findDayByDate->findDayByDate($dateTime, $userId)) {
            throw new DuplicateException('Day already exists');
        }

        return new Day($dateTime, $this->resolver->resolve($dateTime, $userId), $userId);
    }
}
