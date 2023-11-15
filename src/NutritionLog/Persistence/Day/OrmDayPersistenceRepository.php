<?php

declare(strict_types=1);


namespace App\NutritionLog\Persistence\Day;


use App\NutritionLog\Entity\Day;
use App\NutritionLog\Entity\DayMeal;
use App\NutritionLog\Entity\DayMealProduct;
use App\NutritionLog\Entity\DayProduct;
use App\NutritionLog\Value\ConsumptionTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;

final class OrmDayPersistenceRepository implements FindDayByDateInterface, DayPersistenceInterface, RemoveInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function findDayByDate(DateTimeInterface $date): ?Day
    {
        return $this->em->getRepository(Day::class)->findOneBy([
            'date' => $date,
        ]);
    }

    public function store(Day $day): void
    {
        $this->em->persist($day);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function removeProductsAndMeals(Day $day, ConsumptionTime $time): array
    {
        $productIds = [];

        foreach ($day->removeProductsAndMeals($time) as $item) {
            $this->em->remove($item);
            if ($item instanceof DayProduct) {
                $productIds[] = $item->getId();
            }
            if ($item instanceof DayMeal) {
                foreach ($item->getProducts() as $product) {
                    $productIds[] = $product->getId();
                }
            }
        }

        $this->em->flush();

        return $productIds;
    }

    public function removeMealProduct(Day $day, string $mealProductId): void
    {
        $mealProduct = $day->removeMealProduct($mealProductId);
        $this->em->remove($mealProduct);
        $this->em->flush();
    }

    /**
     * @return string[] - ids of removed products
     */
    public function removeMeal(Day $day, string $mealId): array
    {
        $meal = $day->removeMeal($mealId);
        $this->em->remove($meal);
        $this->em->flush();

        return array_map(fn(DayMealProduct $product) => $product->getId(), $meal->getProducts());
    }

    public function removeProduct(Day $day, string $productId): void
    {
        $product = $day->removeProduct($productId);
        $this->em->remove($product);
        $this->em->flush();
    }
}
