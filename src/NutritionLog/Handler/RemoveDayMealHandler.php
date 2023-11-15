<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\RemoveDayMealDtoInterface;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RemoveDayMealHandler
{
    public function __construct(private readonly FindDayByDateInterface $findDayByDate, private readonly RemoveInterface $remove)
    {
    }

    public function __invoke(RemoveDayMealDtoInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay());

        if (!$day) {
            throw new NotFoundException('Day not found');
        }

        $removedMealProductIds = $this->remove->removeMeal($day, $command->getMealId());

        $this->integrationEventBus->dispatch(
            new ProductsRemovedFromNutritionLog(
                array_map(function (string $id) {
                    return new ProductRemovedFromNutritionLog(
                        dayProductId: $id,
                    );
                }, $removedMealProductIds),
            )
        );
    }
}
