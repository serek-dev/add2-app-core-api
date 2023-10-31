<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;

use App\NutritionLog\Dto\RemoveDayProductDtoInterface;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Persistence\Day\RemoveInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RemoveProductHandler
{
    public function __construct(private readonly FindDayByDateInterface $findDayByDate, private readonly RemoveInterface $remove)
    {
    }

    public function __invoke(RemoveDayProductDtoInterface $command): void
    {
        $day = $this->findDayByDate->findDayByDate($command->getDay());

        if (!$day) {
            throw new NotFoundException('There is no day with date: ' . $command->getDay()->format('Y-m-d'));
        }

        $this->remove->removeProduct($day, $command->getProductId());
    }
}
