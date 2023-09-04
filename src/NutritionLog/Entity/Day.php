<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('nutrition_log_day')]
final class Day
{
    #[Id]
    #[GeneratedValue]
    #[Column]
    private readonly ?int $id;

    #[OneToMany(mappedBy: 'day', targetEntity: DayProduct::class, cascade: ['PERSIST'], fetch: "EAGER")]
    private mixed $products;

    #[Column]
    private readonly string $date;

    #[OneToMany(mappedBy: 'day', targetEntity: DayMeal::class, cascade: ['PERSIST'], fetch: "EAGER")]
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
}
