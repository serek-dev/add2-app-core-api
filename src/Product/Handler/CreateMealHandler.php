<?php

declare(strict_types=1);


namespace App\Product\Handler;


use App\Product\Builder\MealBuilder;
use App\Product\Dto\CreateMealDtoInterface;
use App\Product\Exception\NotFoundException;
use App\Product\Persistence\Meal\StoreMealInterface;
use App\Product\Persistence\Product\FindProductByIdInterface;
use App\Product\Value\Weight;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateMealHandler
{
    public function __construct(
        private readonly MealBuilder $mealBuilder,
        private readonly FindProductByIdInterface $findProductById,
        private readonly StoreMealInterface $storeMeal,
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
