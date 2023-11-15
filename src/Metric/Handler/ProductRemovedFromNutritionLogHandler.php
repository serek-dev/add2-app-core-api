<?php

declare(strict_types=1);

namespace App\Metric\Handler;

use App\Metric\Repository\CreateMetricInterface;
use App\Shared\Event\ProductAddedToNutritionLogInterface;
use App\Shared\Event\ProductRemovedFromNutritionLogInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ProductRemovedFromNutritionLogHandler
{
    public function __construct(
        private CreateMetricInterface $createMetric,
    )
    {
    }

    public function __invoke(ProductRemovedFromNutritionLogInterface $event): void
    {
        $this->createMetric->removeByParentIdAndName(
            parentId: $event->getDayProductId(),
            parentName: ProductAddedToNutritionLogInterface::NAME,
        );
    }
}