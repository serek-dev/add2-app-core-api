<?php

declare(strict_types=1);

namespace App\Shared\Event;

interface NutritionLogDayCreatedInterface
{
    public const NAME = 'NutritionLogDayCreated';

    public function getDate(): string;

    public function getKcalTarget(): float;
}