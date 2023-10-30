<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\Weight;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Generator;
use function array_values;
use function is_object;
use function round;

#[Entity]
#[Table('nutrition_log_day')]
class Day
{
    #[Id]
    #[GeneratedValue]
    #[Column]
    private readonly ?int $id;

    #[OneToMany(mappedBy: 'day', targetEntity: DayProduct::class, cascade: ['persist', 'remove'], fetch: "EAGER")]
    private mixed $products;

    #[Column]
    private readonly string $date;

    #[OneToMany(mappedBy: 'day', targetEntity: DayMeal::class, cascade: ['persist', 'remove'], fetch: "EAGER")]
    private mixed $meals;

    public function __construct(
        DateTimeInterface $date,
    ) {
        $this->date = $date->format('Y-m-d');

        $this->products = new ArrayCollection();
        $this->meals = new ArrayCollection();
    }

    public function addProduct(DayProduct $dayProduct): void
    {
        $this->products->add($dayProduct);
        $dayProduct->setDay($this);
    }

    public function getDate(): string
    {
        return $this->date;
    }

    /** @return DayProduct[] */
    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    public function addMeal(DayMeal $dayMeal): void
    {
        $this->meals->add($dayMeal);
        $dayMeal->setDay($this);
    }

    /** @return DayMeal[] */
    public function getMeals(): array
    {
        return $this->meals->toArray();
    }

    public function hasProductsAt(ConsumptionTime $time): bool
    {
        /** @var DayProduct $p */
        foreach ($this->products as $p) {
            if ($p->getConsumptionTime()->equals($time)) {
                return true;
            }
        }

        return false;
    }

    public function hasMealsAt(ConsumptionTime $time): bool
    {
        /** @var DayMeal $p */
        foreach ($this->meals as $p) {
            if ($p->getConsumptionTime()->equals($time)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Generator<DayProduct|DayMeal>
     */
    public function removeProductsAndMeals(ConsumptionTime $time): Generator
    {
        /** @var DayProduct $p */
        foreach ($this->products as $p) {
            if ($p->getConsumptionTime()->equals($time)) {
                $this->products->removeElement($p);
                yield $p;
            }
        }
        /** @var DayMeal $m */
        foreach ($this->meals as $m) {
            if ($m->getConsumptionTime()->equals($time)) {
                $this->meals->removeElement($m);
                yield $m;
            }
        }
    }

    /** @internal */
    public function removeMealProduct(string $mealProductId): DayMealProduct
    {
        foreach ($this->getMeals() as $dayMeal) {
            foreach ($dayMeal->getProducts() as $dayMealProduct) {
                if ($dayMealProduct->getId() === $mealProductId) {
                    $dayMeal->removeProduct($dayMealProduct);
                    return $dayMealProduct;
                }
            }
        }

        throw new NotFoundException("Meal product with id $mealProductId not found");
    }

    public function replaceMealProduct(string $mealId, string $productId, Product $product): void
    {
        $meal = $this->meals->filter(fn(DayMeal $m) => $m->getId() === $mealId)->first();

        if (!is_object($meal)) {
            throw new NotFoundException("Meal with id $mealId not found");
        }

        /** @var DayMealProduct $replacedProduct */
        $replacedProduct = array_values(array_filter($meal->getProducts(), fn(DayMealProduct $p) => $p->getId() === $productId))[0] ?? null;

        if (!is_object($replacedProduct)) {
            throw new NotFoundException("Product with id $productId not found");
        }

        $desiredKcal = $replacedProduct->getKcal();

        $caloriesPer100g = $product->getNutritionValues()->getKcal();

        $amountNeeded = round(($desiredKcal) / ($caloriesPer100g) * 100, 2);

        $replacedProduct->replaceByProduct($product);
        $replacedProduct->changeWeight(new Weight($amountNeeded));
    }

    /**
     * @throws NotFoundException
     */
    public function removeMeal(string $mealId): DayMeal
    {
        $meal = $this->meals->filter(fn(DayMeal $m) => $m->getId() === $mealId)->first();

        if (!is_object($meal)) {
            throw new NotFoundException("Meal with id $mealId not found");
        }

        $this->meals->removeElement($meal);
        return $meal;
    }
}
