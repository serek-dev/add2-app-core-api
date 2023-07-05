<?php

declare(strict_types=1);


namespace App\Product\Command;


use App\Product\Dto\CreateMealDtoInterface;

final class CreateMealCommand implements CreateMealDtoInterface
{
    /**
     * @param array<array{id: string, weight: float}> $products
     */
    public function __construct(
        private readonly string $name,
        private readonly array $products,

    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @inheritDoc */
    public function getProducts(): array
    {
        return $this->products;
    }
}
