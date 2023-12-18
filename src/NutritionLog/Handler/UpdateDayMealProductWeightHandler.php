<?php

declare(strict_types=1);

namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\UpdateDayMealProductWeightDtoInterface;
use App\NutritionLog\Event\ProductUpdatedInNutritionLog;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\DayPersistenceInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class UpdateDayMealProductWeightHandler
{
    public function __construct(private FindDayByDateInterface  $find,
                                private DayPersistenceInterface $persistence,
                                private MessageBusInterface     $integrationEventBus

    )
    {
    }

    public function __invoke(UpdateDayMealProductWeightDtoInterface $dto): void
    {
        $day = $this->find->findDayByDate($dto->getDay(), $dto->getUserId());

        if (!$day) {
            throw new NotFoundException('Day: ' . $dto->getDay() . ' does not exist');
        }

        $kcal = $day->changeMealProductWeight($dto->getMealId(), $dto->getProductId(), $dto->getWeight());

        $this->persistence->store($day);

        $this->integrationEventBus->dispatch(
            new ProductUpdatedInNutritionLog(
                dayProductId: $dto->getProductId(),
                date: $dto->getDay(),
                newKcal: $kcal,
                userId: $dto->getUserId(),
            )
        );
    }
}