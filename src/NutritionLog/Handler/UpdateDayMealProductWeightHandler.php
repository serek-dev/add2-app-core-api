<?php

declare(strict_types=1);

namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\UpdateDayMealProductWeightDtoInterface;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\DayPersistenceInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateDayMealProductWeightHandler
{
    public function __construct(private readonly FindDayByDateInterface  $find,
                                private readonly DayPersistenceInterface $persistence,
    )
    {
    }

    public function __invoke(UpdateDayMealProductWeightDtoInterface $dto): void
    {
        $day = $this->find->findDayByDate($dto->getDay());

        if (!$day) {
            throw new NotFoundException('Day: ' . $dto->getDay() . ' does not exist');
        }

        $day->changeMealProductWeight($dto->getMealId(), $dto->getProductId(), $dto->getWeight());

        $this->persistence->store($day);
    }
}