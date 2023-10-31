<?php

declare(strict_types=1);


namespace App\NutritionLog\Command;


use App\NutritionLog\Dto\RemoveDayProductDtoInterface;
use DateTimeImmutable;
use DateTimeInterface;

final class RemoveDayProductDtoCommand implements RemoveDayProductDtoInterface
{
    public function __construct(
        private readonly string $date,
        private readonly string $productId,
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
}
