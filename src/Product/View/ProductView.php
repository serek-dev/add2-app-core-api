<?php

declare(strict_types=1);


namespace App\Product\View;


use JsonSerializable;

final class ProductView implements JsonSerializable
{
    private string $id;

    private string $name;

    private ?string $producerName = null;

    private float $proteins;

    private float $fats;

    private float $carbs;

    private float $kcal;

    private float $weight = 100.0;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getProducerName(): ?string
    {
        return $this->producerName;
    }

    public function setProducerName(?string $producerName): self
    {
        $this->producerName = $producerName;
        return $this;
    }

    public function getProteins(): float
    {
        return $this->proteins;
    }

    public function setProteins(float $proteins): self
    {
        $this->proteins = $proteins;
        return $this;
    }

    public function getFats(): float
    {
        return $this->fats;
    }

    public function setFats(float $fats): self
    {
        $this->fats = $fats;
        return $this;
    }

    public function getCarbs(): float
    {
        return $this->carbs;
    }

    public function setCarbs(float $carbs): self
    {
        $this->carbs = $carbs;
        return $this;
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }

    public function setKcal(float $kcal): self
    {
        $this->kcal = $kcal;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'producerName' => $this->producerName,
            'proteins' => $this->proteins,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
            'kcal' => $this->kcal,
            'weight' => $this->weight,
        ];
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }
}
