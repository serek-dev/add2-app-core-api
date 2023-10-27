<?php

namespace App\Catalog\Handler;

use App\Catalog\Dto\RemoveMealProductDtoInterface;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Persistence\Meal\FindMealByIdInterface;
use App\Catalog\Persistence\Meal\MealPersistenceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RemoveMealProductHandler
{
    public function __construct(
        private readonly FindMealByIdInterface    $findMealById,
        private readonly MealPersistenceInterface $persistence,
    )
    {
    }

    public function __invoke(RemoveMealProductDtoInterface $dto): void
    {
        $meal = $this->findMealById->findById($dto->getProductId());

        if (!$meal) {
            throw new NotFoundException('Meal: ' . $dto->getProductId() . ' does not exist');
        }

        if (!$meal->hasProduct($dto->getProductId())) {
            throw new NotFoundException('Meal: ' . $dto->getProductId() . ' does not exist');
        }

        $this->persistence->removeProduct($meal, $dto->getProductId());
    }
}