<?php

declare(strict_types=1);

namespace App\Metric\Handler;

use App\Metric\Factory\MetricFactoryDirector;
use App\Metric\Repository\CreateMetricInterface;
use App\Shared\Event\ProductAddedToNutritionLogInterface;
use App\Shared\Event\ProductsAddedToNutritionLogInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use function array_map;

#[AsMessageHandler]
final readonly class ProductsAddedToNutritionLogHandler
{
    public function __construct(
        private CreateMetricInterface $createMetric,
        private MetricFactoryDirector $factory
    )
    {
    }

    public function __invoke(ProductsAddedToNutritionLogInterface $event): void
    {
        $this->createMetric->store(
            ...array_map(
            fn(ProductAddedToNutritionLogInterface $e) => $this->factory->createFromProductAddedToNutritionLog($e),
            $event->getDayProducts()
        ),
        );
    }
}