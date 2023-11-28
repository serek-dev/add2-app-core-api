<?php

declare(strict_types=1);


namespace App\Catalog\Command;


use App\Catalog\Dto\CreateMealDtoInterface;

final class CreateMealCommand implements CreateMealDtoInterface
{
    /**
     * @param array<array{id: string, weight: float}> $products
     */
    public function __construct(
        private readonly string $userId,
        private readonly string $name,
        private readonly array  $products,
        private readonly ?string $id = null,
    )
    {
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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
