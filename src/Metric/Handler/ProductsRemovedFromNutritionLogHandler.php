<?php

declare(strict_types=1);

namespace App\Metric\Handler;

use App\Metric\Repository\CreateMetricInterface;
use App\Shared\Event\ProductAddedToNutritionLogInterface;
use App\Shared\Event\ProductsRemovedFromNutritionLogInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ProductsRemovedFromNutritionLogHandler
{
    public function __construct(
        private CreateMetricInterface $persistence,
    )
    {
    }

    public function __invoke(ProductsRemovedFromNutritionLogInterface $event): void
    {
        foreach ($event->getDayProducts() as $e) {
            $this->persistence->removeByParentIdAndName(
                parentId: $e->getDayProductId(),
                parentName: ProductAddedToNutritionLogInterface::NAME,
            );
        }
    }
}