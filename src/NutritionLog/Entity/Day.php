<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Value\ConsumptionTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Generator;

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
}
