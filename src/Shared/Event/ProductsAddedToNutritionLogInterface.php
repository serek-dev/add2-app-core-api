<?php

declare(strict_types=1);

namespace App\Shared\Event;

/**
 *  Don't think to change this class name as it will break the removal method!
 */
interface ProductsAddedToNutritionLogInterface
{
    public const NAME = 'ProductsAddedToNutritionLog';

    /**
     * @return ProductAddedToNutritionLogInterface[]
     */
    public function getDayProducts(): array;
}