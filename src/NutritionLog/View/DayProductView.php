<?php

declare(strict_types=1);


namespace App\NutritionLog\View;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity(readOnly: true)]
#[Table("nutrition_log_day_product")]
final class DayProductView implements JsonSerializable, LogAbleInterface
{
    #[ManyToOne(targetEntity: DayView::class, inversedBy: 'products')]
    private DayView $day;

    public function __construct(
        #[Id]
        #[GeneratedValue]
        #[Column]
        public readonly string $id,
        #[Column]
        public readonly string $consumptionTime,
        #[Column]
        public readonly string $productId,
        #[Column]
        public readonly string $productName,
        #[Column(nullable: true)]
        public readonly ?string $producerName,
        #[Column]
        private readonly float $proteins,
        #[Column]
        private readonly float $fats,
        #[Column]
        private readonly float $carbs,
        #[Column]
        private readonly float $kcal,
        #[Column]
        private readonly float $weight,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'consumptionTime' => $this->consumptionTime,
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
