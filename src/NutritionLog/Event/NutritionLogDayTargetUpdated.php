<?php

declare(strict_types=1);

namespace App\NutritionLog\Event;

use App\Shared\Event\NutritionLogDayTargetUpdatedInterface;

final readonly class NutritionLogDayTargetUpdated implements NutritionLogDayTargetUpdatedInterface
{
    public function __construct(
        private string $date,
        private float  $kcalTarget,
        private string $userId,
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

    public function getUserId(): string
    {
        return $this->userId;
    }
}