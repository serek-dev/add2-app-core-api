<?php

declare(strict_types=1);

namespace App\Catalog\Command;

use App\Catalog\Dto\RemoveMealDtoInterface;

final class RemoveMealCommand implements RemoveMealDtoInterface
{
    public function __construct(public readonly string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}