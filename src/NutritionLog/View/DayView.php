<?php

declare(strict_types=1);


namespace App\NutritionLog\View;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity(readOnly: true)]
#[Table("nutrition_log_day")]
class DayView implements JsonSerializable, LogAbleInterface
{
    #[OneToMany(mappedBy: 'day', targetEntity: DayProductView::class, fetch: "EAGER")]
    #[OrderBy(["consumptionTime" => 'ASC'])]
    private Collection $products;

    #[OneToMany(mappedBy: 'day', targetEntity: DayMealView::class, fetch: "EAGER")]
    #[OrderBy(["consumptionTime" => 'ASC'])]
    private Collection $meals;

    public function __construct(
        #[Id]
        #[GeneratedValue]
        #[Column]
        public readonly ?string $id,
        #[Column(type: 'date')]
        public readonly string $date,
    ) {
        $this->products = new ArrayCollection();
        $this->meals = new ArrayCollection();
    }

    public static function createEmpty(string $date): self
    {
        return new self(null, $date);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'proteins' => $this->getProteins(),
            'fats' => $this->getFats(),
            'carbs' => $this->getCarbs(),
            'kcal' => $this->getKcal(),
            'weight' => $this->getWeight(),
            'products' => $this->products->toArray(),
            'meals' => $this->meals->toArray(),
        ];
    }

    public function getProteins(): float
    {
        $product = round(array_sum(array_map(fn(DayProductView $p) => $p->getProteins(), $this->products->toArray())), 2);
        $meal = round(array_sum(array_map(fn(DayMealView $p) => $p->getProteins(), $this->meals->toArray())), 2);
        return round($product + $meal, 2);
    }

    public function getFats(): float
    {
        $product = round(array_sum(array_map(fn(DayProductView $p) => $p->getFats(), $this->products->toArray())), 2);
        $meal = round(array_sum(array_map(fn(DayMealView $p) => $p->getFats(), $this->meals->toArray())), 2);
        return round($product + $meal, 2);
    }

    public function getCarbs(): float
    {
        $product = round(array_sum(array_map(fn(DayProductView $p) => $p->getCarbs(), $this->products->toArray())), 2);
        $meal = round(array_sum(array_map(fn(DayMealView $p) => $p->getCarbs(), $this->meals->toArray())), 2);
        return round($product + $meal, 2);
    }

    public function getKcal(): float
    {
        $product = round(array_sum(array_map(fn(DayProductView $p) => $p->getKcal(), $this->products->toArray())), 2);
        $meal = round(array_sum(array_map(fn(DayMealView $p) => $p->getKcal(), $this->meals->toArray())), 2);
        return round($product + $meal, 2);
    }

    public function getWeight(): float
    {
        $product = round(array_sum(array_map(fn(DayProductView $p) => $p->getWeight(), $this->products->toArray())), 2);
        $meal = round(array_sum(array_map(fn(DayMealView $p) => $p->getWeight(), $this->meals->toArray())), 2);
        return round($product + $meal, 2);
    }

    /** @return DayProductView[] */
    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    /** @return DayMealView[] */
    public function getMeals(): array
    {
        return $this->meals->toArray();
    }
}
