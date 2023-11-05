<?php

declare(strict_types=1);


namespace App\NutritionLog\Value;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
final class NutritionalValues
{
    #[Column(nullable: true)] private float $proteins = 0.0;
    #[Column(nullable: true)] private float $fats = 0.0;
    #[Column(nullable: true)] private float $carbs = 0.0;

    public function __construct(
        Weight                 $proteins,
        Weight                 $fats,
        Weight                 $carbs,
        #[Column(nullable: true)]
        private readonly float $kcal = 0.0,
    )
    {
        $this->carbs = $carbs->getRaw();
        $this->fats = $fats->getRaw();
        $this->proteins = $proteins->getRaw();
    }

    public function getProteins(): Weight
    {
        return new Weight($this->proteins);
    }

    public function getFats(): Weight
    {
        return new Weight($this->fats);
    }

    public function getCarbs(): Weight
    {
        return new Weight($this->carbs);
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }
}
