<?php

declare(strict_types=1);

namespace App\Catalog\Specification\Meal;

use App\Catalog\Entity\Meal;
use App\Catalog\Exception\DuplicateException;
use App\Catalog\Persistence\Meal\FindMealByNameInterface;
use App\Catalog\Specification\MealSpecificationInterface;

final readonly class UniqueNameSpecification implements MealSpecificationInterface
{
    public function __construct(
        private FindMealByNameInterface $find,
    )
    {
    }

    public function isSatisfiedBy(Meal $meal): bool
    {
        $existingMeal = $this->find->findByName($meal->getName(), $meal->getUserId());

        if ($existingMeal && $existingMeal->getId() !== $meal->getId()) {
            throw new DuplicateException(
                "Meal with name: {$meal->getName()} already exist for user {$meal->getUserId()}"
            );
        }

        return true;
    }
}