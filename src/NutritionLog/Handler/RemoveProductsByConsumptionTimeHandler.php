<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\RemoveDayProductsByConsumptionTimeInterface;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RemoveProductsByConsumptionTimeHandler
{
    public function __construct(private readonly FindDayByDateInterface $findDayByDate, private readonly RemoveInterface $remove)
    {
    }

    public function __invoke(RemoveDayProductsByConsumptionTimeInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay());

        if (!$day) {
            throw new NotFoundException("There is no meal eaten at: " . $command->getConsumptionTime());
        }

        if (!$day->hasProductsAt($command->getConsumptionTime()) && !$day->hasMealsAt($command->getConsumptionTime())) {
            throw new NotFoundException("There is no meal or product eaten at: " . $command->getConsumptionTime());
        }

        $this->remove->removeProductsAndMeals($day, $command->getConsumptionTime());
    }
}
