<?php

declare(strict_types=1);

namespace App\Shared\Entity;

interface AggregateRoot
{
    public function getId(): string|int;

    /**
     * Should remove all events from the entity!
     *
     * @return object[]
     */
    public function pullEvents(): array;
}