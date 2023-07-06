<?php

declare(strict_types=1);


namespace App\Diary\Handler;


use App\Diary\Dto\AddDayProductDtoInterface;
use App\Diary\Exception\NotFoundException;
use App\Diary\Factory\DayFactory;
use App\Diary\Factory\DayProductFactory;
use App\Diary\Persistence\Day\FindDayByDateInterface;
use App\Diary\Persistence\Day\StoreDayInterface;
use App\Diary\Repository\Product\GetOneProductInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class AddDayProductHandler
{
    // todo: missing test
    public function __construct(
        private readonly FindDayByDateInterface $findDayByDate,
        private readonly StoreDayInterface $storeDay,
        private readonly DayFactory $dayFactory,
        private readonly DayProductFactory $dayProductFactory,
        private readonly GetOneProductInterface $getOneProduct,
    ) {
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

        $this->storeDay->store($day);
    }
}
