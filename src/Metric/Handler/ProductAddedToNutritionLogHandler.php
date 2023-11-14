<?php

declare(strict_types=1);

namespace App\Metric\Handler;

use App\Metric\Factory\MetricFactoryDirector;
use App\Metric\Repository\CreateMetricInterface;
use App\Shared\Event\ProductAddedToNutritionLogInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ProductAddedToNutritionLogHandler
{
    public function __construct(
        private CreateMetricInterface $createMetric,
        private MetricFactoryDirector $factory
    )
    {
    }

    public function __invoke(ProductAddedToNutritionLogInterface $event): void
    {
        $this->createMetric->store(
            $this->factory->createFromProductAddedToNutritionLog($event),
        );
    }
}