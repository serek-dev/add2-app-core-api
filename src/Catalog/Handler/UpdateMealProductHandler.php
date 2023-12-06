<?php

namespace App\Catalog\Handler;

use App\Catalog\Dto\UpdateMealProductWeightDtoInterface;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Persistence\Meal\FindMealByIdInterface;
use App\Catalog\Persistence\Meal\MealPersistenceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateMealProductHandler
{
    public function __construct(
        private FindMealByIdInterface    $find,
        private MealPersistenceInterface $persistence,
    )
    {
    }

    public function __invoke(UpdateMealProductWeightDtoInterface $dto): void
    {
        $meal = $this->find->findByIdAndUser($dto->getMealId(), $dto->getUserId());

        if (!$meal) {
            throw new NotFoundException('Meal: ' . $dto->getMealId() . ' does not exist');
        }

        $meal->changeProductWeight($dto->getProductId(), $dto->getWeight());

        $this->persistence->store($meal);
    }
}