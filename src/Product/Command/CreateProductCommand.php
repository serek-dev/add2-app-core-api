<?php

declare(strict_types=1);


namespace App\Product\Command;


use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;

final class CreateProductCommand implements CreateProductDtoInterface
{
    public function __construct(
        private readonly string $name,
        private readonly float $proteins,
        private readonly float $fats,
        private readonly float $carbs,
        private readonly float $kcal,
        private readonly ?string $producerName,
    ) {
    }

    public function getNutritionValues(): NutritionalValues
    {
        return new NutritionalValues(
            new Weight($this->proteins),
            new Weight($this->fats),
            new Weight($this->carbs),
            $this->kcal,
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProducerName(): ?string
    {
        return $this->producerName;
    }
}
