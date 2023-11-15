<?php

declare(strict_types=1);

namespace App\Shared\Event;

interface ProductRemovedFromNutritionLogInterface
{
    public function getDayProductId(): string;
}