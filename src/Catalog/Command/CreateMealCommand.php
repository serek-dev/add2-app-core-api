<?php

declare(strict_types=1);


namespace App\Catalog\Command;


use App\Catalog\Dto\CreateMealDtoInterface;

final readonly class CreateMealCommand implements CreateMealDtoInterface
{
    /**
     * @param array<array{id: string, weight: float}> $products
     */
    public function __construct(
        private string  $userId,
        private string  $name,
        private array   $products,
        private ?string $description = null,
        private ?string $id = null,
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

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
