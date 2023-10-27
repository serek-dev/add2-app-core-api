<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\RemoveDayMealProductInterface;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RemoveDayMealProductHandler
{
    public function __construct(private readonly FindDayByDateInterface $findDayByDate, private readonly RemoveInterface $remove)
    {
    }

    public function __invoke(RemoveDayMealProductInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay());

        if (!$day) {
            throw new NotFoundException('Day not found');
        }

        $this->remove->removeMealProduct($day, $command->getProductId());
    }
}
