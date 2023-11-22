<?php

declare(strict_types=1);

namespace App\NutritionLog\Event;

use App\Shared\Event\NutritionLogDayCreatedInterface;

final readonly class NutritionLogDayCreated implements NutritionLogDayCreatedInterface
{
    public function __construct(
        private string $date,
        private float  $kcalTarget,
    )
    {
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getKcalTarget(): float
    {
        return $this->kcalTarget;
    }
}