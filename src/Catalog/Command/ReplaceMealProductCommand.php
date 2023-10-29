<?php

declare(strict_types=1);

namespace App\Catalog\Command;

use App\Catalog\Dto\ReplaceMealProductDtoInterface;

final class ReplaceMealProductCommand implements ReplaceMealProductDtoInterface
{
    public function __construct(
        private readonly string $mealId,
        private readonly string $productId,
        private readonly string $newProductId,
    )
    {
    }

    public function getMealId(): string
    {
        return $this->mealId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getNewProductId(): string
    {
        return $this->newProductId;
    }
}