<?php

declare(strict_types=1);


namespace App\Catalog\Handler;


use App\Catalog\Dto\UpdateMealDtoInterface;
use App\Catalog\Persistence\Meal\FindMealByIdInterface;
use App\Catalog\Persistence\Meal\MealPersistenceInterface;
use App\Catalog\Specification\MealSpecificationInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final readonly class UpdateMealHandler
{
    /**
     * @param MealSpecificationInterface[] $specifications
     */
    public function __construct(
        private FindMealByIdInterface    $find,
        private MealPersistenceInterface $storeMeal,
        private iterable                 $specifications = [],

    )
    {
        foreach ($this->specifications as $s) {
            if (!$s instanceof MealSpecificationInterface) {
                throw new RuntimeException(
                    'Specification should implement MealSpecificationInterface'
                );
            }
        }
    }

    /**
     * @throws Throwable
     */
    public function __invoke(UpdateMealDtoInterface $dto): void
    {
        $meal = $this->find->findByIdAndUser($dto->getId(), $dto->getUserId());

        $meal->setName($dto->getName());
        $meal->setDescription($dto->getDescription());

        foreach ($this->specifications as $spec) {
            $spec->isSatisfiedBy(clone $meal);
        }

        $this->storeMeal->store($meal);
    }
}
