<?php

declare(strict_types=1);


namespace App\Product\Entity;

interface AggregateRoot
{
    public function getId(): string;

    /**
     * @return object[]
     */
    public function pullEvents(): array;
}
