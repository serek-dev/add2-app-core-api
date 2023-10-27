<?php

declare(strict_types=1);


namespace App\NutritionLog\View;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity(readOnly: true)]
#[Table("nutrition_log_day_meal")]
class DayMealView implements JsonSerializable, LogAbleInterface
{
    #[ManyToOne(targetEntity: DayView::class, inversedBy: 'meals')]
    private DayView $day;

    #[OneToMany(mappedBy: 'meal', targetEntity: DayMealProductView::class, fetch: "EAGER")]
    private Collection $products;

    public function __construct(
        #[Id]
        #[GeneratedValue]
        #[Column]
        public readonly string $id,
        #[Column]
        public readonly string $consumptionTime,
        #[Column]
        private readonly string $name,
        #[Column]
        private readonly bool $modified = false,
    ) {
        $this->products = new ArrayCollection();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'consumptionTime' => $this->consumptionTime,
            'name' => $this->name,
            'proteins' => $this->getProteins(),
            'fats' => $this->getFats(),
            'carbs' => $this->getCarbs(),
            'kcal' => $this->getKcal(),
            'weight' => $this->getWeight(),
            'modified' => $this->isModified(),
            'products' => $this->products->toArray(),
        ];
    }

    public function getProteins(): float
    {
        return round(array_sum(array_map(fn(DayMealProductView $p) => $p->getProteins(), $this->products->toArray())), 2);
    }

    public function getFats(): float
    {
        return round(array_sum(array_map(fn(DayMealProductView $p) => $p->getFats(), $this->products->toArray())), 2);
    }

    public function getCarbs(): float
    {
        return round(array_sum(array_map(fn(DayMealProductView $p) => $p->getCarbs(), $this->products->toArray())), 2);
    }

    public function getKcal(): float
    {
        return round(array_sum(array_map(fn(DayMealProductView $p) => $p->getKcal(), $this->products->toArray())), 2);
    }

    public function getWeight(): float
    {
        return round(array_sum(array_map(fn(DayMealProductView $p) => $p->getWeight(), $this->products->toArray())), 2);
    }

    public function isModified(): bool
    {
        return $this->modified;
    }
}
