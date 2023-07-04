<?php

declare(strict_types=1);


namespace App\Product\Entity;


use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;

final class MealProduct
{
    private float $proteins;
    private float $fats;
    private float $carbs;
    private float $kcal;

    public function __construct(
        private readonly string $id,
        private readonly NutritionalValues $nutritionalValues,
        private readonly string $name,
        private readonly string $parentId,
        private readonly ?string $producerName
    ) {
        $this->proteins = $this->nutritionalValues->getProteins();
        $this->fats = $this->nutritionalValues->getFats();
        $this->carbs = $this->nutritionalValues->getCarbs();
        $this->kcal = $this->nutritionalValues->getKcal();
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
