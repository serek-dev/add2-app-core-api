<?php

declare(strict_types=1);


namespace App\Diary\Value;


final class ProductDetail
{
    public function __construct(
        private readonly string $originalProductId,
        private readonly string $originalProductName,
        private readonly ?string $originalProducerName = null,
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
}
