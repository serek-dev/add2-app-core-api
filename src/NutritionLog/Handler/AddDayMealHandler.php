<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;


use App\NutritionLog\Dto\AddDayMealDtoInterface;
use App\NutritionLog\Event\ProductAddedToNutritionLog;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Factory\DayFactory;
use App\NutritionLog\Factory\DayMealFactory;
use App\NutritionLog\Persistence\Day\DayPersistenceInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Repository\Meal\GetOneMealInterface;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class AddDayMealHandler
{
    // todo: missing test
    public function __construct(
        private readonly FindDayByDateInterface  $findDayByDate,
        private readonly DayPersistenceInterface $storeDay,
        private readonly DayFactory              $dayFactory,
        private readonly DayMealFactory          $dayMealFactory,
        private readonly GetOneMealInterface     $getOneMeal,
        private readonly MessageBusInterface $integrationEventBus
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(AddDayMealDtoInterface $dto): void
    {
        $day = $this->findDayByDate->findDayByDate($dto->getDay());

        if (!$day) {
            $day = $this->dayFactory->create($dto->getDay());
        }

        $dayMeal = $this->dayMealFactory->create(
            consumptionTime: $dto->getConsumptionTime(),
            realMeal: $realMeal = $this->getOneMeal->getOne($dto->getMealId())
        );

        $day->addMeal($dayMeal);

        $this->integrationEventBus->dispatch(
            new ProductAddedToNutritionLog(
                dayProductId: $realMeal->getId(),
                productName: $realMeal->getName(),
                date: DateTimeImmutable::createFromFormat('Y-m-d H:i', $day->getDate() . ' ' . $dto->getConsumptionTime()),
                kcal: $dayMeal->getKcal(),
            )
        );

        $this->storeDay->store($day);
    }
}
