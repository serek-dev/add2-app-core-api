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
final class DayMealProductView implements JsonSerializable
{
    #[Id]
    #[GeneratedValue(strategy: "NONE")]
    #[Column]
    private readonly string $id;
    #[Column]
    private float $weight;
    #[Column]
    private float $proteins;
    #[Column]
    private float $fats;
    #[Column]
    private float $carbs;
    #[Column]
    private float $kcal;

    #[ManyToOne(targetEntity: DayMealView::class, inversedBy: 'products')]
    private DayMealView $meal;

    #[Column]
    private string $productId;
    #[Column]
    private string $productName;
    #[Column(nullable: true)]
    private ?string $producerName;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'productId' => $this->productId,
            'productName' => $this->productName,
            'proteins' => $this->getProteins(),
            'fats' => $this->getFats(),
            'carbs' => $this->getCarbs(),
            'kcal' => $this->getKcal(),
            'weight' => $this->getWeight(),
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
