<?php

declare(strict_types=1);

namespace App\Shared\Event;

use DateTimeInterface;

interface ProductAddedToNutritionLogInterface
{
    public function getDayProductId(): string;

    public function getDate(): DateTimeInterface;

    public function getKcal(): float;
}