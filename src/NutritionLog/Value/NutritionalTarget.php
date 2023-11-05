<?php

declare(strict_types=1);


namespace App\NutritionLog\Value;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use DomainException;
use function array_sum;

#[Embeddable]
final class NutritionalTarget
{
    public function __construct(
        #[Column(options: ['default' => 0])]
        private readonly int   $proteins,
        #[Column(options: ['default' => 0])]
        private readonly int   $fats,
        #[Column(options: ['default' => 0])]
        private readonly int   $carbs,
        #[Column(options: ['default' => 0])]
        private readonly float $kcal,
    )
    {
        if ($this->proteins === 0 && $this->fats === 0 && $this->carbs === 0) {
            return;
        }

        if (array_sum(compact('proteins', 'fats', 'carbs')) !== 100) {
            throw new DomainException('Nutritional target percentage sum must be 100');
        }
    }

    public function getProteins(): int
    {
        return $this->proteins;
    }

    public function getFats(): int
    {
        return $this->fats;
    }

    public function getCarbs(): int
    {
        return $this->carbs;
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }
}
