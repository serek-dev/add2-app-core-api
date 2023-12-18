<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\RemoveDayMealDtoInterface;
use App\NutritionLog\Event\ProductRemovedFromNutritionLog;
use App\NutritionLog\Event\ProductsRemovedFromNutritionLog;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use function array_map;

#[AsMessageHandler]
final readonly class RemoveDayMealHandler
{
    public function __construct(private FindDayByDateInterface $findDayByDate,
                                private RemoveInterface        $remove,
                                private MessageBusInterface    $integrationEventBus

    )
    {
    }

    public function __invoke(RemoveDayMealDtoInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay(), $command->getUserId());

        if (!$day) {
            throw new NotFoundException('Day not found');
        }

        $removedMealProductIds = $this->remove->removeMeal($day, $command->getMealId());

        $this->integrationEventBus->dispatch(
            new ProductsRemovedFromNutritionLog(
                array_map(function (string $id) use ($command) {
                    return new ProductRemovedFromNutritionLog(
                        dayProductId: $id,
                        userId: $command->getUserId(),
                    );
                }, $removedMealProductIds),
            )
        );
    }
}
