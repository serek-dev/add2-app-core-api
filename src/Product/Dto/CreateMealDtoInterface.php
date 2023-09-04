<?php

declare(strict_types=1);


namespace App\Product\Dto;

interface CreateMealDtoInterface
{
    public function getName(): string;

    /**
     * @return array<array{id: string, weight: float}>
     */
    public function getProducts(): array;

    public function getId(): ?string;
}
