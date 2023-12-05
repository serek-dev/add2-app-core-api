<?php

declare(strict_types=1);


namespace App\Catalog\View;


use App\Catalog\Value\Portion;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JetBrains\PhpStorm\Immutable;
use JsonSerializable;

#[Entity(readOnly: true)]
#[Table('catalog_product')]
#[Immutable]
class ProductView implements JsonSerializable
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

    #[Column]
    private string $userId;

    #[Embedded(class: Portion::class, columnPrefix: false)]
    private ?Portion $portion = null;

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
            'unit' => $this->portion?->getUnit(),
            'weightPerUnit' => $this->portion?->getWeightPerUnit(),
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
