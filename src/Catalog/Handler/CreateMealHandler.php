<?php

declare(strict_types=1);


namespace App\Catalog\Handler;


use App\Catalog\Builder\MealBuilder;
use App\Catalog\Dto\CreateMealDtoInterface;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Persistence\Meal\MealPersistenceInterface;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Value\Weight;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateMealHandler
{
    public function __construct(
        private readonly MealBuilder              $mealBuilder,
        private readonly FindProductByIdInterface $findProductById,
        private readonly MealPersistenceInterface $storeMeal,
    ) {
    }

    public function __invoke(CreateMealDtoInterface $createMealDto): void
    {
        foreach ($createMealDto->getProducts() as $idWeight) {
            $this->mealBuilder->addProduct(
                new Weight($idWeight['weight']),
                $this->findProductById->findById(
                    $idWeight['id']
                ) ?? throw new NotFoundException(
                'Product: ' . $idWeight['id'] . ' does not exist'
            )
            );
        }

        if ($createMealDto->getId()) {
            $this->mealBuilder->withId($createMealDto->getId());
        }

        $meal = $this->mealBuilder->build($createMealDto->getName());

        $this->storeMeal->store($meal);
    }
}
