<?php

declare(strict_types=1);


namespace App\Catalog\Command;


use App\Catalog\Dto\UpdateMealDtoInterface;

final readonly class UpdateMealCommand implements UpdateMealDtoInterface
{
    public function __construct(
        private string  $userId,
        private string  $name,
        private ?string $description = null,
        private ?string $id = null,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getId(): string
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
