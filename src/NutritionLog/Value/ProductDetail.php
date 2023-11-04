<?php

declare(strict_types=1);


namespace App\NutritionLog\Value;


final class ProductDetail
{
    public function __construct(
        private readonly string $originalProductId,
        private readonly string $originalProductName,
        private readonly ?string $originalProducerName = null,
        private readonly ?Portion $portion = null,
    ) {
    }

    public function getOriginalProductId(): string
    {
        return $this->originalProductId;
    }

    public function getOriginalProductName(): string
    {
        return $this->originalProductName;
    }

    public function getOriginalProducerName(): ?string
    {
        return $this->originalProducerName;
    }

    public function getPortion(): ?Portion
    {
        return $this->portion;
    }
}
