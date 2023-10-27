<?php

declare(strict_types=1);

namespace App\Catalog\Command;

use App\Catalog\Dto\RemoveMealProductDtoInterface;

final class RemoveMealProductCommand implements RemoveMealProductDtoInterface
{
    public function __construct(public readonly string $mealId, public readonly string $productId)
    {
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getMealId(): string
    {
        return $this->mealId;
    }
}