<?php

declare(strict_types=1);


namespace App\NutritionLog\Command;


use App\NutritionLog\Dto\RemoveDayProductDtoInterface;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class RemoveDayProductDtoCommand implements RemoveDayProductDtoInterface
{
    public function __construct(
        private string $date,
        private string $productId,
        private string $userId,
    )
    {
    }

    public function getDay(): DateTimeInterface
    {
        return new DateTimeImmutable($this->date);
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
