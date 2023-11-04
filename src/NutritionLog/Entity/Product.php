<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\Portion;
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
        private readonly ?string  $producerName,
        private readonly ?Portion $portion = null
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

    public function getPortion(): ?Portion
    {
        return $this->portion;
    }

    public static function createFromArray(array $body): Product
    {
        return new self(
            id: $body['id'],
            nutritionalValues: new NutritionalValues(
                new Weight((float)$body['proteins']),
                new Weight((float)$body['fats']),
                new Weight((float)$body['carbs']),
                (float)$body['kcal'],
            ),
            name: $body['name'],
            weight: isset($body['weight']) ? new Weight($body['weight']) : new Weight(100.0),
            producerName: $body['producerName'],
            portion: isset($body['unit']) && isset($body['weightPerUnit']) ? new Portion($body['unit'], $body['weightPerUnit']) : null,
        );
    }
}
