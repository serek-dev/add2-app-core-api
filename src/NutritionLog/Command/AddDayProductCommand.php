<?php

declare(strict_types=1);


namespace App\NutritionLog\Command;


use App\NutritionLog\Dto\AddDayProductDtoInterface;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\Weight;
use DateTimeImmutable;
use DateTimeInterface;

final class AddDayProductCommand implements AddDayProductDtoInterface
{
    public function __construct(
        private readonly string $date,
        private readonly string $consumptionTime,
        private readonly string $productId,
        private readonly float $productWeight,
        private readonly string $userId,
    ) {
    }

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->date);
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getConsumptionTime(): ConsumptionTime
    {
        return new ConsumptionTime($this->consumptionTime);
    }

    public function getProductWeight(): Weight
    {
        return new Weight($this->productWeight);
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
