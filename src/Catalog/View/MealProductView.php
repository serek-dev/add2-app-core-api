<?php

declare(strict_types=1);


namespace App\Catalog\View;


use App\Catalog\Value\Portion;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity(readOnly: true)]
#[Table('catalog_meal_product')]
class MealProductView implements JsonSerializable
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
    private float $weight = 100.0;

    #[ManyToOne(MealView::class, fetch: 'EAGER', inversedBy: 'products')]
    private MealView $meal;

    #[Embedded(class: Portion::class, columnPrefix: false)]
    private ?Portion $portion = null;

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
        return round($this->proteins, 2);
    }

    public function setProteins(float $proteins): self
    {
        $this->proteins = $proteins;
        return $this;
    }

    public function getFats(): float
    {
        return round($this->fats, 2);
    }

    public function setFats(float $fats): self
    {
        $this->fats = round($fats, 1);
        return $this;
    }

    public function getCarbs(): float
    {
        return round($this->carbs, 2);
    }

    public function setCarbs(float $carbs): self
    {
        $this->carbs = round($carbs, 1);
        return $this;
    }

    public function getKcal(): float
    {
        return round($this->kcal, 2);
    }

    public function setKcal(float $kcal): self
    {
        $this->kcal = round($kcal, 2);
        return $this;
    }

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
            'weight' => $this->getWeight(),
            'unit' => $this->portion->getUnit(),
            'weightPerUnit' => $this->portion->getWeightPerUnit(),
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
        return round($this->weight, 2);
    }

    public function setWeight(float $weight): self
    {
        $this->weight = round($weight, 1);
        return $this;
    }

    public function getPortion(): ?Portion
    {
        return $this->portion;
    }
}
