<?php

declare(strict_types=1);


namespace App\NutritionLog\Factory;


use App\NutritionLog\Entity\DayMeal;
use App\NutritionLog\Entity\DayMealProduct;
use App\NutritionLog\Entity\Meal;
use App\NutritionLog\Entity\Product;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\ProductDetail;

// todo: missing test
final class DayMealFactory
{
    public function create(
        ConsumptionTime $consumptionTime,
        Meal $realMeal,
    ): DayMeal {
        return new DayMeal(
            uniqid('NL-DM-'),
            $realMeal->getName(),
            $consumptionTime,
            array_map(function (Product $p) use ($consumptionTime): DayMealProduct {
                return new DayMealProduct(
                    uniqid('NL-DMP-'),
                    $p->getWeight(),
                    $p->getNutritionValues(),
                    new ProductDetail(
                        $p->getId(),
                        $p->getName(),
                        $p->getProducerName(),
                        $p->getPortion(),
                    )
                );
            }, $realMeal->getProducts()),
        );
    }
}
