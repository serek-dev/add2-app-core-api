<?php

declare(strict_types=1);

namespace App\Catalog\Command;

use App\Catalog\Dto\RemoveProductDtoInterface;

final class RemoveProductCommand implements RemoveProductDtoInterface
{
    public function __construct(public readonly string $id, private readonly string $userId)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}