<?php

declare(strict_types=1);

namespace App\Shared\Event;

interface NutritionLogDayTargetUpdatedInterface
{
    public function getDate(): string;

    public function getKcalTarget(): float;
}