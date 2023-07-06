<?php

declare(strict_types=1);


namespace App\Diary\Entity;


use App\Diary\Value\NutritionalValues;
use App\Diary\Value\Weight;

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
}
