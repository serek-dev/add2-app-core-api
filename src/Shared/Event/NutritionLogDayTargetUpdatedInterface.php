<?php

declare(strict_types=1);

namespace App\Shared\Event;

interface NutritionLogDayTargetUpdatedInterface
{
    public const NAME = 'NutritionLogDayTargetUpdated';

    public function getDate(): string;

    public function getKcalTarget(): float;

    public function getUserId(): string;
}