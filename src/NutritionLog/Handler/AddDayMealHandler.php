<?php

declare(strict_types=1);


namespace App\NutritionLog\Handler;


use App\NutritionLog\Dto\AddDayMealDtoInterface;
use App\NutritionLog\Entity\Day;
use App\NutritionLog\Entity\DayMealProduct;
use App\NutritionLog\Event\ProductAddedToNutritionLog;
use App\NutritionLog\Event\ProductsAddedToNutritionLog;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Factory\DayFactory;
use App\NutritionLog\Factory\DayMealFactory;
use App\NutritionLog\Persistence\Day\DayPersistenceInterface;
use App\NutritionLog\Persistence\Day\FindDayByDateInterface;
use App\NutritionLog\Repository\Meal\GetOneMealInterface;
use App\Shared\Integration\DomainEventsPublisherInterface;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use function array_map;

#[AsMessageHandler]
final readonly class AddDayMealHandler
{
    // todo: missing test
    public function __construct(
        private FindDayByDateInterface         $findDayByDate,
        private DayPersistenceInterface        $storeDay,
        private DayFactory                     $dayFactory,
        private DayMealFactory                 $dayMealFactory,
        private GetOneMealInterface            $getOneMeal,
        private MessageBusInterface            $integrationEventBus,
        private DomainEventsPublisherInterface $domainEventsPublisher,
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(AddDayMealDtoInterface $dto): void
    {
        $day = $this->findDayByDate->findDayByDate($dto->getDay(), $dto->getUserId());

        if (!$day) {
            $day = $this->dayFactory->create($dto->getDay(), $dto->getUserId());
        }

        $dayMeal = $this->dayMealFactory->create(
            consumptionTime: $dto->getConsumptionTime(),
            realMeal: $this->getOneMeal->getOne($dto->getMealId(), $dto->getUserId()),
        );

        $day->addMeal($dayMeal);

        $this->storeDay->store($day);

        $this->domainEventsPublisher->publishFrom($day);

        $this->integrationEventBus->dispatch(
            new ProductsAddedToNutritionLog(
                array_map(function (DayMealProduct $product) use ($dto, $day) {
                    return new ProductAddedToNutritionLog(
                        dayProductId: $product->getId(),
                        date: $this->extractDateTime($day, $dto),
                        kcal: $product->getKcal(),
                        userId: $dto->getUserId(),
                    );
                }, $dayMeal->getProducts()),
            )
        );
    }

    private function extractDateTime(?Day $day, AddDayMealDtoInterface $dto): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat('Y-m-d H:i', $day->getDate() . ' ' . $dto->getConsumptionTime());
    }
}
