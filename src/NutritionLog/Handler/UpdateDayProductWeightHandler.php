<?php

declare(strict_types=1);

namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\UpdateDayProductWeightDtoInterface;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\DayPersistenceInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateDayProductWeightHandler
{
    public function __construct(private readonly FindDayByDateInterface  $find,
                                private readonly DayPersistenceInterface $persistence,
    )
    {
    }

    public function __invoke(UpdateDayProductWeightDtoInterface $dto): void
    {
        $day = $this->find->findDayByDate($dto->getDay());

        if (!$day) {
            throw new NotFoundException('Day: ' . $dto->getDay() . ' does not exist');
        }

        $day->changeProductWeight($dto->getProductId(), $dto->getWeight());

        $this->persistence->store($day);
    }
}