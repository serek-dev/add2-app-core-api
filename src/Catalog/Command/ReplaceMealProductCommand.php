<?php

declare(strict_types=1);

namespace App\Catalog\Command;

use App\Catalog\Dto\ReplaceMealProductDtoInterface;

final readonly class ReplaceMealProductCommand implements ReplaceMealProductDtoInterface
{
    public function __construct(
        private string $mealId,
        private string $productId,
        private string $newProductId,
        private string $userId,
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

    public function getUserId(): string
    {
        return $this->userId;
    }
}