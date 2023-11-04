<?php

declare(strict_types=1);


namespace App\NutritionLog\Value;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
final class NutritionalValues
{
    #[Column(nullable: true)] private readonly float $proteins;
    #[Column(nullable: true)] private readonly float $fats;
    #[Column(nullable: true)] private readonly float $carbs;

    public function __construct(
        Weight                 $proteins,
        Weight                 $fats,
        Weight                 $carbs,
        #[Column(nullable: true)]
        private readonly float $kcal,
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
