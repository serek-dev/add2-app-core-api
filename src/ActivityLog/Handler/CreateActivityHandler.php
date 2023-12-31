<?php

declare(strict_types=1);

namespace App\ActivityLog\Handler;

use App\ActivityLog\Command\CreateActivityCommand;
use App\ActivityLog\Factory\ActivityFactory;
use App\ActivityLog\Repository\PersistenceInterface;
use App\Shared\Integration\DomainEventsPublisherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateActivityHandler
{
    public function __construct(private PersistenceInterface           $persistence,
                                private ActivityFactory                $factory,
                                private DomainEventsPublisherInterface $publisher)
    {
    }

    public function __invoke(CreateActivityCommand $command): void
    {
        $activity = $this->factory->create($command);

        $this->publisher->publishFrom($activity);

        $this->persistence->store($activity);
    }
}