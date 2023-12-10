<?php

declare(strict_types=1);

namespace App\Metric\Handler;

use App\Metric\Factory\MetricFactoryDirector;
use App\Metric\Repository\CreateMetricInterface;
use App\Metric\Value\MetricType;
use App\Shared\Event\NutritionLogDayCreatedInterface;
use App\Shared\Event\NutritionLogDayTargetUpdatedInterface;
use DateTimeImmutable;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class NutritionLogDayCreatedHandler
{
    public function __construct(
        private CreateMetricInterface $createMetric,
        private MetricFactoryDirector $factory
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(NutritionLogDayCreatedInterface|NutritionLogDayTargetUpdatedInterface $event): void
    {
        $this->createMetric->store(
            $this->factory->createByArguments(
                type: MetricType::KCAL_TARGET,
                value: $event->getKcalTarget(),
                date: new DateTimeImmutable($event->getDate()),
                userId: $event->getUserId(),
                parentId: $event->getDate(),
                parentName: $event::NAME,
            ),
        );
    }
}