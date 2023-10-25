<?php

namespace App\Catalog\Handler;

use App\Catalog\Dto\RemoveMealDtoInterface;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Persistence\Meal\FindMealByIdInterface;
use App\Catalog\Persistence\Meal\MealPersistenceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RemoveMealHandler
{
    public function __construct(
        private readonly FindMealByIdInterface    $findMealById,
        private readonly MealPersistenceInterface $persistence,
    )
    {
    }

    public function __invoke(RemoveMealDtoInterface $dto): void
    {
        $meal = $this->findMealById->findById($dto->getId());

        if (!$meal) {
            throw new NotFoundException('Meal: ' . $dto->getId() . ' does not exist');
        }

        $this->persistence->remove($meal);
    }
}