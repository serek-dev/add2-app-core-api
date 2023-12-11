<?php

declare(strict_types=1);

namespace App\NutritionLog\Command;

use App\NutritionLog\Dto\RemoveDayMealProductInterface;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class RemoveDayMealProductCommand implements RemoveDayMealProductInterface
{
    public function __construct(
        private string $day,
        private string $productId,
        private string $userId,
    )
    {
    }

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->day);
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}