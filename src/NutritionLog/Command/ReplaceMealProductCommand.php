<?php

declare(strict_types=1);

namespace App\NutritionLog\Command;


use App\NutritionLog\Dto\ReplaceMealProductDtoInterface;
use DateTimeImmutable;
use DateTimeInterface;

final class ReplaceMealProductCommand implements ReplaceMealProductDtoInterface
{
    public function __construct(
        private readonly string $day,
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

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->day);
    }
}