<?php

declare(strict_types=1);

namespace App\NutritionLog\Event;

use App\Shared\Event\ProductRemovedFromNutritionLogInterface;

final readonly class ProductRemovedFromNutritionLog implements ProductRemovedFromNutritionLogInterface
{
    public function __construct(
        private string $dayProductId,
        private string $userId,
    )
    {
    }

    public function getDayProductId(): string
    {
        return $this->dayProductId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}