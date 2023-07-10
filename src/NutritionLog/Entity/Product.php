<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\Weight;

final class Product
{
    private float $proteins;
    private float $fats;
    private float $carbs;
    private float $kcal;

    public function __construct(
        private readonly string $id,
        private readonly NutritionalValues $nutritionalValues,
        private readonly string $name,
        private readonly Weight $weight,
        private readonly ?string $producerName
    ) {
        $this->proteins = $this->nutritionalValues->getProteins()->getRaw();
        $this->fats = $this->nutritionalValues->getFats()->getRaw();
        $this->carbs = $this->nutritionalValues->getCarbs()->getRaw();
        $this->kcal = $this->nutritionalValues->getKcal();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProducerName(): ?string
    {
        return $this->producerName;
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

    public function getWeight(): Weight
    {
        return new Weight($this->weight->getRaw());
    }
}
