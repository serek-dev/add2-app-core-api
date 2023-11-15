<?php

declare(strict_types=1);

namespace App\NutritionLog\Event;

use App\Shared\Event\ProductRemovedFromNutritionLogInterface;

final readonly class ProductRemovedFromNutritionLog implements ProductRemovedFromNutritionLogInterface
{
    public function __construct(
        private string $dayProductId,
    )
    {
    }

    public function getDayProductId(): string
    {
        return $this->dayProductId;
    }
}