<?php

declare(strict_types=1);


namespace App\NutritionLog\View;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use JetBrains\PhpStorm\Immutable;
use JsonSerializable;

#[Entity(readOnly: true)]
#[Table('nutrition_log_day_meal_product')]
#[Immutable]
class DayMealProductView implements JsonSerializable, LogAbleInterface
{
    #[Id]
    #[GeneratedValue(strategy: "NONE")]
    #[Column]
    private readonly string $id;
    #[Column]
    private readonly float $weight;
    #[Column]
    private readonly float $proteins;
    #[Column]
    private readonly float $fats;
    #[Column]
    private readonly float $carbs;
    #[Column]
    private readonly float $kcal;

    #[ManyToOne(targetEntity: DayMealView::class, inversedBy: 'products')]
    private readonly DayMealView $meal;

    #[Column]
    private readonly string $productId;
    #[Column]
    private readonly string $productName;
    #[Column(nullable: true)]
    private readonly ?string $producerName;

    #[Column(nullable: true)]
    private readonly ?string $unit;
    #[Column(nullable: true)]
    private readonly ?int $weightPerUnit;


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'productId' => $this->productId,
            'name' => $this->productName,
            'proteins' => $this->getProteins(),
            'fats' => $this->getFats(),
            'carbs' => $this->getCarbs(),
            'kcal' => $this->getKcal(),
            'weight' => $this->getWeight(),
            'unit' => $this->unit,
            'weightPerUnit' => $this->weightPerUnit,
        ];
    }

    public function getProteins(): float
    {
        return round($this->proteins, 2);
    }

    public function getFats(): float
    {
        return round($this->fats, 2);
    }

    public function getCarbs(): float
    {
        return round($this->carbs, 2);
    }

    public function getKcal(): float
    {
        return round($this->kcal, 2);
    }

    public function getWeight(): float
    {
        return round($this->weight, 2);
    }
}
