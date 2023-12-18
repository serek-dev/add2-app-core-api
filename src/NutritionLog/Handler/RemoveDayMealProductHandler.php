<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\RemoveDayMealProductInterface;
use App\NutritionLog\Event\ProductRemovedFromNutritionLog;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class RemoveDayMealProductHandler
{
    public function __construct(private FindDayByDateInterface $findDayByDate,
                                private MessageBusInterface    $integrationEventBus,
                                private RemoveInterface        $remove)
    {
    }

    public function __invoke(RemoveDayMealProductInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay(), $command->getUserId());

        if (!$day) {
            throw new NotFoundException('Day not found');
        }

        $this->remove->removeMealProduct($day, $command->getProductId());

        $this->integrationEventBus->dispatch(
            new ProductRemovedFromNutritionLog(
                dayProductId: $command->getProductId(),
                userId: $command->getUserId(),
            )
        );
    }
}
