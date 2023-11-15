<?php

declare(strict_types=1);

namespace App\Shared\Event;

/**
 *  Don't think to change this class name as it will break the removal method!
 */
interface ProductsRemovedFromNutritionLogInterface
{
    public const NAME = 'ProductsRemovedFromNutritionLog';

    /**
     * @return ProductRemovedFromNutritionLogInterface[]
     */
    public function getDayProducts(): array;
}