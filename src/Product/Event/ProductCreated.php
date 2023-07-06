<?php

declare(strict_types=1);


namespace App\Product\Event;


use App\Shared\Event\ProductCreatedInterface;

final class ProductCreated implements ProductCreatedInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly float $proteins,
        private readonly float $fats,
        private readonly float $carbs,
        private readonly float $kcal,
        private readonly ?string $producerName,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProteins(): float
    {
        return $this->proteins;
    }

    public function getFats(): float
    {
        return $this->fats;
    }

    public function getCarbs(): float
    {
        return $this->carbs;
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }

    public function getProducerName(): ?string
    {
        return $this->producerName;
    }
}
