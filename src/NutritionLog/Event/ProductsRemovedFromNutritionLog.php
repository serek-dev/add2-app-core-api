<?php

declare(strict_types=1);

namespace App\NutritionLog\Event;

use App\Shared\Event\ProductRemovedFromNutritionLogInterface;
use App\Shared\Event\ProductsRemovedFromNutritionLogInterface;
use InvalidArgumentException;

final readonly class ProductsRemovedFromNutritionLog implements ProductsRemovedFromNutritionLogInterface
{
    /**
     * @param ProductRemovedFromNutritionLogInterface[] $productsRemoved
     */
    public function __construct(private array $productsRemoved)
    {
        foreach ($this->productsRemoved as $p) {
            if (!$p instanceof ProductRemovedFromNutritionLogInterface) {
                throw new InvalidArgumentException('Invalid product removed to nutrition log');
            }

        }
    }

    /** @inheritDoc */
    public function getDayProducts(): array
    {
        return $this->productsRemoved;
    }
}