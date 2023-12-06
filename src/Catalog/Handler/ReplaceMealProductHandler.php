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
final readonly class ReplaceMealProductHandler
{
    public function __construct(private FindMealByIdInterface    $findMeal,
                                private FindProductByIdInterface $findProduct,
                                private MealPersistenceInterface $persistence)
    {
    }

    public function __invoke(ReplaceMealProductDtoInterface $command): void
    {
        $meal = $this->findMeal->findByIdAndUser($command->getMealId(), $command->getUserId());

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