<?php

declare(strict_types=1);

namespace App\NutritionLog\Command;


use App\NutritionLog\Dto\ReplaceMealProductDtoInterface;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class ReplaceMealProductCommand implements ReplaceMealProductDtoInterface
{
    public function __construct(
        private string $day,
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

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->day);
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}