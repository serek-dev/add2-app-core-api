<?php

declare(strict_types=1);


namespace App\Tests\Application\NutritionLog;


use App\NutritionLog\Command\AddDayMealCommand;
use App\NutritionLog\Command\AddDayProductCommand;
use App\Tests\Application\ApplicationTestCase;

abstract class NutritionLogTestCase extends ApplicationTestCase
{
    protected function withMealInNutritionLog(string $day, string $consumptionTime, string $mealId): self
    {
        $this->bus->dispatch(
            new AddDayMealCommand(
                $day,
                $consumptionTime,
                $mealId,
            )
        );

        return $this;
    }

    protected function withProductInNutritionLog(string $day, string $consumptionTime, string $productId, float $productWeight): self
    {
        $this->bus->dispatch(
            new AddDayProductCommand(
                date: $day,
                consumptionTime: $consumptionTime,
                productId: $productId,
                productWeight: $productWeight,
            )
        );

        return $this;
    }
}
