<?php

declare(strict_types=1);


namespace App\Product\View;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JetBrains\PhpStorm\Immutable;
use JsonSerializable;

#[Entity(readOnly: true)]
#[Table('p_product')]
#[Immutable]
final class ProductView implements JsonSerializable
{
    #[Id]
    #[GeneratedValue(strategy: "NONE")]
    #[Column]
    private string $id;

    #[Column]
    private string $name;

    #[Column(nullable: true)]
    private ?string $producerName = null;

    #[Column]
    private float $proteins;

    #[Column]
    private float $fats;

    #[Column]
    private float $carbs;

    #[Column]
    private float $kcal;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'producerName' => $this->producerName,
            'proteins' => $this->getProteins(),
            'fats' => $this->getFats(),
            'carbs' => $this->getCarbs(),
            'kcal' => $this->getKcal(),
        ];
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

    public function getProteins(): float
    {
        return round($this->proteins, 2);
    }

    public function getFats(): float
    {
        return round($this->fats, 2);
    }

    public function getCarbs(): float
    {
        return round($this->carbs, 2);
    }

    public function getKcal(): float
    {
        return round($this->kcal, 2);
    }
}
