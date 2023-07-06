<?php

declare(strict_types=1);


namespace App\Diary\Command;


use App\Diary\Dto\AddDayProductDtoInterface;
use App\Diary\Value\ConsumptionTime;
use App\Diary\Value\Weight;
use DateTimeImmutable;
use DateTimeInterface;

final class AddDayProductCommand implements AddDayProductDtoInterface
{
    public function __construct(
        private readonly string $date,
        private readonly string $consumptionTime,
        private readonly string $productId,
        private readonly float $productWeight,
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
}
