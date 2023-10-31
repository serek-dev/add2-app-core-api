<?php

declare(strict_types=1);


namespace App\Catalog\Command;


use App\Catalog\Dto\CreateProductDtoInterface;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Portion;
use App\Catalog\Value\Weight;

final class CreateProductCommand implements CreateProductDtoInterface
{
    public function __construct(
        private readonly string $name,
        private readonly float $proteins,
        private readonly float $fats,
        private readonly float $carbs,
        private readonly float $kcal,
        private readonly ?string $producerName,
        private readonly ?string $id = null,
        private readonly ?string $unit = null,
        private readonly ?int    $weightPerUnit = null,
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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getPortion(): ?Portion
    {
        if ($this->unit && $this->weightPerUnit) {
            return new Portion($this->unit, $this->weightPerUnit);
        }

        return null;
    }
}
