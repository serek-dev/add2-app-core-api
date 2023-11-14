<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;


use App\NutritionLog\Dto\AddDayProductDtoInterface;
use App\NutritionLog\Event\ProductAddedToNutritionLog;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Factory\DayFactory;
use App\NutritionLog\Factory\DayProductFactory;
use App\NutritionLog\Persistence\Day\DayPersistenceInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Repository\Product\GetOneProductInterface;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class AddDayProductHandler
{
    // todo: missing test
    public function __construct(
        private readonly FindDayByDateInterface  $findDayByDate,
        private readonly DayPersistenceInterface $storeDay,
        private readonly DayFactory              $dayFactory,
        private readonly DayProductFactory       $dayProductFactory,
        private readonly GetOneProductInterface  $getOneProduct,
        private readonly MessageBusInterface     $integrationEventBus
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(AddDayProductDtoInterface $dto): void
    {
        $day = $this->findDayByDate->findDayByDate($dto->getDay());

        if (!$day) {
            $day = $this->dayFactory->create($dto->getDay());
        }

        $dayProduct = $this->dayProductFactory->create(
            consumptionTime: $dto->getConsumptionTime(),
            product: $this->getOneProduct->getOne($dto->getProductId()),
            quantity: $dto->getProductWeight()
        );

        $day->addProduct($dayProduct);

        $this->integrationEventBus->dispatch(
            new ProductAddedToNutritionLog(
                dayProductId: $dayProduct->getId(),
                date: DateTimeImmutable::createFromFormat('Y-m-d H:i', $day->getDate() . ' ' . $dto->getConsumptionTime()),
                kcal: $dayProduct->getNutritionValues()->getKcal(),
            )
        );

        $this->storeDay->store($day);
    }
}
