<?php

declare(strict_types=1);

namespace App\NutritionLog\Event;

use App\Shared\Event\ProductAddedToNutritionLogInterface;
use App\Shared\Event\ProductsAddedToNutritionLogInterface;
use InvalidArgumentException;

final readonly class ProductsAddedToNutritionLog implements ProductsAddedToNutritionLogInterface
{
    /**
     * @param ProductAddedToNutritionLogInterface[] $productsAdded
     */
    public function __construct(private array $productsAdded)
    {
        foreach ($this->productsAdded as $p) {
            if (!$p instanceof ProductAddedToNutritionLogInterface) {
                throw new InvalidArgumentException('Invalid product added to nutrition log');
            }

        }
    }

    /** @inheritDoc */
    public function getDayProducts(): array
    {
        return $this->productsAdded;
    }
}