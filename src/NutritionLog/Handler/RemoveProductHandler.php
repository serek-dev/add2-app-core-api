<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\RemoveDayProductDtoInterface;
use App\NutritionLog\Event\ProductRemovedFromNutritionLog;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class RemoveProductHandler
{
    public function __construct(
        private readonly FindDayByDateInterface $findDayByDate,
        private MessageBusInterface             $integrationEventBus,
        private readonly RemoveInterface        $remove
    )
    {
    }

    public function __invoke(RemoveDayProductDtoInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay(), $command->getUserId());

        if (!$day) {
            throw new NotFoundException('There is no day with date: ' . $command->getDay()->format('Y-m-d'));
        }

        $this->remove->removeProduct($day, $command->getProductId());

        $this->integrationEventBus->dispatch(
            new ProductRemovedFromNutritionLog(
                dayProductId: $command->getProductId(),
                userId: $command->getUserId(),
            )
        );
    }
}
