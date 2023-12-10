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
        private string $userId,
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

    public function getUserId(): string
    {
        return $this->userId;
    }
}