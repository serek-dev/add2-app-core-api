<?php

declare(strict_types=1);

namespace App\NutritionLog\Event;

use App\Shared\Event\ProductUpdatedInNutritionLogInterface;
use DateTimeInterface;

final readonly class ProductUpdatedInNutritionLog implements ProductUpdatedInNutritionLogInterface
{
    public function __construct(
        private string            $dayProductId,
        private DateTimeInterface $date,
        private float             $newKcal,
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

    public function getNewKcal(): float
    {
        return $this->newKcal;
    }
}