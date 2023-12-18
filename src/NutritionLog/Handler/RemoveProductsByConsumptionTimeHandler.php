<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\RemoveDayProductsByConsumptionTimeInterface;
use App\NutritionLog\Event\ProductRemovedFromNutritionLog;
use App\NutritionLog\Event\ProductsRemovedFromNutritionLog;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use function array_map;

#[AsMessageHandler]
final readonly class RemoveProductsByConsumptionTimeHandler
{
    public function __construct(
        private FindDayByDateInterface $findDayByDate,
        private MessageBusInterface    $integrationEventBus,
        private RemoveInterface        $remove
    )
    {
    }

    public function __invoke(RemoveDayProductsByConsumptionTimeInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay(), $command->getUserId());

        if (!$day) {
            throw new NotFoundException("There is no meal eaten at: " . $command->getConsumptionTime());
        }

        if (!$day->hasProductsAt($command->getConsumptionTime()) && !$day->hasMealsAt($command->getConsumptionTime())) {
            throw new NotFoundException("There is no meal or product eaten at: " . $command->getConsumptionTime());
        }

        $removedMealAndProductIds = $this->remove->removeProductsAndMeals($day, $command->getConsumptionTime());

        $this->integrationEventBus->dispatch(
            new ProductsRemovedFromNutritionLog(
                array_map(function (string $id) use ($command) {
                    return new ProductRemovedFromNutritionLog(
                        dayProductId: $id,
                        userId: $command->getUserId(),
                    );
                }, $removedMealAndProductIds),
            )
        );
    }
}
