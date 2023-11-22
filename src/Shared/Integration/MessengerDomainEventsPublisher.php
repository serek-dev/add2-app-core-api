<?php

declare(strict_types=1);

namespace App\Shared\Integration;

use App\Shared\Entity\AggregateRoot;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerDomainEventsPublisher implements DomainEventsPublisherInterface
{
    public function __construct(private MessageBusInterface $domainEventsBus)
    {
    }

    public function publishFrom(AggregateRoot $aggregateRoot): void
    {
        foreach ($aggregateRoot->pullEvents() as $event) {
            $this->domainEventsBus->dispatch($event);
        }
    }
}