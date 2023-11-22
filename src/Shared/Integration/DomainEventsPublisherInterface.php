<?php

declare(strict_types=1);

namespace App\Shared\Integration;

use App\Shared\Entity\AggregateRoot;

interface DomainEventsPublisherInterface
{
    public function publishFrom(AggregateRoot $aggregateRoot): void;
}