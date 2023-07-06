<?php

declare(strict_types=1);


namespace App\Diary\Dto;

use App\Diary\Value\ConsumptionTime;
use App\Diary\Value\Weight;
use DateTimeInterface;

interface AddDayProductDtoInterface
{
    public function getDay(): DateTimeInterface;

    public function getConsumptionTime(): ConsumptionTime;

    public function getProductId(): string;

    public function getProductWeight(): Weight;
}
