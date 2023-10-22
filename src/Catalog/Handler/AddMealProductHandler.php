<?php

namespace App\Catalog\Handler;

use App\Catalog\Dto\AddMealProductDto;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Factory\MealProductFactory;
use App\Catalog\Persistence\Meal\FindMealByIdInterface;
use App\Catalog\Persistence\Meal\StoreMealInterface;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class AddMealProductHandler
{
    public function __construct(
        private readonly FindMealByIdInterface    $findMealById,
        private readonly FindProductByIdInterface $findProductById,
        private readonly MealProductFactory       $mealProductFactory,
        private readonly StoreMealInterface       $storeMeal,
    )
    {
    }

    public function __invoke(AddMealProductDto $dto): void
    {
        $product = $this->findProductById->findById($dto->getProductId());

        if (!$product) {
            throw new NotFoundException('Product: ' . $dto->getProductId() . ' does not exist');
        }

        $meal = $this->findMealById->findById($dto->getMealId());

        if (!$meal) {
            throw new NotFoundException('Meal: ' . $dto->getMealId() . ' does not exist');
        }

        $mealProduct = $this->mealProductFactory->create($product, $dto->getWeight());

        $meal->addProduct($mealProduct);

        $this->storeMeal->store($meal);
    }
}