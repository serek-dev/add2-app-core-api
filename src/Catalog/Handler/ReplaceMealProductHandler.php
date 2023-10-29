<?php

declare(strict_types=1);

namespace App\Catalog\Handler;

use App\Catalog\Dto\ReplaceMealProductDtoInterface;
use App\Catalog\Exception\NotFoundException;
use App\Catalog\Persistence\Meal\FindMealByIdInterface;
use App\Catalog\Persistence\Meal\MealPersistenceInterface;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ReplaceMealProductHandler
{
    public function __construct(private readonly FindMealByIdInterface    $findMeal,
                                private readonly FindProductByIdInterface $findProduct,
                                private readonly MealPersistenceInterface $persistence)
    {
    }

    public function __invoke(ReplaceMealProductDtoInterface $command): void
    {
        $meal = $this->findMeal->findById($command->getMealId());

        if (!$meal) {
            throw new NotFoundException('Meal not found');
        }

        $product = $this->findProduct->findById($command->getNewProductId());

        if (!$product) {
            throw new NotFoundException('Product not found');
        }

        $meal->replaceProduct($command->getProductId(), $product);

        $this->persistence->store($meal);
    }
}