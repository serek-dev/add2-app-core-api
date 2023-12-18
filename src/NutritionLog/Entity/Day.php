<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Event\NutritionLogDayCreated;
use App\NutritionLog\Event\NutritionLogDayTargetUpdated;
use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\NutritionalTarget;
use App\NutritionLog\Value\Weight;
use App\Shared\Entity\AggregateRoot;
use DateTimeInterface;
use DivisionByZeroError;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Generator;
use function array_filter;
use function array_values;
use function is_object;
use function round;

#[Entity]
#[Table('nutrition_log_day')]
class Day implements AggregateRoot
{
    #[Id]
    #[GeneratedValue]
    #[Column]
    private readonly ?int $id;

    #[OneToMany(mappedBy: 'day', targetEntity: DayProduct::class, cascade: ['persist', 'remove'], fetch: "EAGER")]
    private mixed $products;

    #[OneToMany(mappedBy: 'day', targetEntity: DayMeal::class, cascade: ['persist', 'remove'], fetch: "EAGER")]
    private mixed $meals;
    private array $events = [];

    public function __construct(
        #[Column(type: 'date')]
        private readonly DateTimeInterface $date,
        #[Embedded(class: NutritionalTarget::class)]
        private NutritionalTarget          $target,
        #[Column]
        private readonly string            $userId,
    )
    {
        $this->products = new ArrayCollection();
        $this->meals = new ArrayCollection();

        $this->events[] = new NutritionLogDayCreated(
            date: $this->date->format('Y-m-d'),
            kcalTarget: $this->target->getKcal(),
            userId: $this->userId,
        );
    }

    public function addProduct(DayProduct $dayProduct): void
    {
        $this->products->add($dayProduct);
        $dayProduct->setDay($this);
    }

    public function getDate(): string
    {
        return $this->date->format('Y-m-d');
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

        try {
            $amountNeeded = round(($desiredKcal) / ($caloriesPer100g) * 100, 2);
        } catch (DivisionByZeroError $e) {
            $amountNeeded = 0;
        }

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

    /**
     * @return float - new number of kcal
     */
    public function changeMealProductWeight(string $mealId, string $productId, Weight $newWeight): float
    {
        $meal = $this->meals->filter(fn(DayMeal $m) => $m->getId() === $mealId)->first();

        if (!is_object($meal)) {
            throw new NotFoundException("Meal with id $mealId not found");
        }

        /** @var DayMealProduct $product */
        $product = array_values(array_filter($meal->getProducts(), fn(DayMealProduct $p) => $p->getId() === $productId))[0] ?? null;

        $product->changeWeight($newWeight);

        return $product->getKcal();
    }

    public function removeProduct(string $productId): DayProduct
    {
        foreach ($this->products as $p) {
            if ($p->getId() === $productId) {
                $this->products->removeElement($p);
                return $p;
            }
        }

        throw new NotFoundException("Product with id $productId not found");
    }

    public function changeProductWeight(string $productId, Weight $weight): float
    {
        /** @var DayProduct $product */
        $product = $this->products->filter(fn(DayProduct $m) => $m->getId() === $productId)->first();

        if (!is_object($product)) {
            throw new NotFoundException("Product with id $productId not found");
        }

        $product->changeWeight($weight);

        return $product->getNutritionValues()->getKcal();
    }

    public function changeTarget(NutritionalTarget $new): void
    {
        $this->target = $new;

        $this->events[] = new NutritionLogDayTargetUpdated(
            date: $this->date->format('Y-m-d'),
            kcalTarget: $new->getKcal()
        );
    }

    public function getTarget(): NutritionalTarget
    {
        return $this->target;
    }

    public function getId(): string|int
    {
        return $this->id;
    }

    /** @inheritDoc */
    public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }
}
