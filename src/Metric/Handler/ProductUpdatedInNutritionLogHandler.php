<?php

declare(strict_types=1);

namespace App\Metric\Handler;

use App\Metric\Repository\CreateMetricInterface;
use App\Metric\Value\MetricType;
use App\Shared\Event\ProductUpdatedInNutritionLogInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ProductUpdatedInNutritionLogHandler
{
    public function __construct(
        private CreateMetricInterface $metric,
    )
    {
    }

    public function __invoke(ProductUpdatedInNutritionLogInterface $event): void
    {
        $this->metric->updateByParentIdAndType(
            $event->getDayProductId(),
            MetricType::KCAL,
            $event->getNewKcal(),
        );
    }
}