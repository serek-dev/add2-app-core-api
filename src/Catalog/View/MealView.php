<?php

declare(strict_types=1);


namespace App\Catalog\View;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use JetBrains\PhpStorm\Immutable;
use JsonSerializable;

#[Entity(readOnly: true)]
#[Table('catalog_meal')]
#[Immutable]
class MealView implements JsonSerializable
{
    #[Id]
    #[Column]
    public string $id;

    #[Column]
    public string $name;

    #[Column]
    public string $userId;

    private function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /** @var MealProductView[]&Collection */
    #[OneToMany(mappedBy: 'meal', targetEntity: MealProductView::class, fetch: 'EAGER')]
    private Collection $products;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'proteins' => $this->getProteins(),
            'fats' => $this->getFats(),
            'carbs' => $this->getCarbs(),
            'kcal' => $this->getKcal(),
            'weight' => $this->getWeight(),
            'products' => $this->products->toArray(),
        ];
    }

    public function getProteins(): float
    {
        return round(array_sum(array_map(fn(MealProductView $p) => $p->getProteins(), $this->products->toArray())), 2);
    }

    public function getFats(): float
    {
        return round(array_sum(array_map(fn(MealProductView $p) => $p->getFats(), $this->products->toArray())), 2);
    }

    public function getCarbs(): float
    {
        return round(array_sum(array_map(fn(MealProductView $p) => $p->getCarbs(), $this->products->toArray())), 2);
    }

    public function getKcal(): float
    {
        return round(array_sum(array_map(fn(MealProductView $p) => $p->getKcal(), $this->products->toArray())), 2);
    }

    public function getWeight(): float
    {
        return round(array_sum(array_map(fn(MealProductView $p) => $p->getWeight(), $this->products->toArray())), 2);
    }
}
