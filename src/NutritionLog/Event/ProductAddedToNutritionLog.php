<?php

declare(strict_types=1);

namespace App\NutritionLog\Event;

use App\Shared\Event\ProductAddedToNutritionLogInterface;
use DateTimeInterface;

final readonly class ProductAddedToNutritionLog implements ProductAddedToNutritionLogInterface
{
    public function __construct(
        private string            $dayProductId,
        private DateTimeInterface $date,
        private float             $kcal,
    )
    {
    }

    public function getDayProductId(): string
    {
        return $this->dayProductId;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }
}