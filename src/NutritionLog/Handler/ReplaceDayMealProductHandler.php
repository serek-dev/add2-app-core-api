<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\ReplaceMealProductDtoInterface;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\DayPersistenceInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Repository\Product\GetOneProductInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ReplaceDayMealProductHandler
{
    public function __construct(
        private readonly FindDayByDateInterface  $findDayByDate,
        private readonly GetOneProductInterface  $product,
        private readonly DayPersistenceInterface $persistence
    )
    {
    }

    public function __invoke(ReplaceMealProductDtoInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay());

        if (!$day) {
            throw new NotFoundException('Day not found');
        }

        $day->replaceMealProduct(
            $command->getMealId(),
            $command->getProductId(),
            $this->product->getOne($command->getNewProductId())
        );

        $this->persistence->store($day);
    }
}
