<?php

declare(strict_types=1);


namespace App\NutritionLog\Command;


use App\NutritionLog\Dto\RemoveDayProductsByConsumptionTimeInterface;
use App\NutritionLog\Value\ConsumptionTime;
use DateTimeImmutable;
use DateTimeInterface;

final class RemoveDayProductsByConsumptionTimeCommand implements RemoveDayProductsByConsumptionTimeInterface
{
    public function __construct(
        private readonly string $date,
        private readonly string $consumptionTime,
    ) {
    }

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->date);
    }

    public function getConsumptionTime(): ConsumptionTime
    {
        return new ConsumptionTime($this->consumptionTime);
    }
}
