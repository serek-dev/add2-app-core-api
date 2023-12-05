<?php

declare(strict_types=1);


namespace App\Catalog\Entity;


use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Portion;
use App\Catalog\Value\Weight;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('catalog_product')]
class Product
{
    #[Column]
    private float $proteins;
    #[Column]
    private float $fats;
    #[Column]
    private float $carbs;
    #[Column]
    private float $kcal;

    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        private readonly NutritionalValues $nutritionalValues,
        #[Column]
        private string          $userId,
        #[Column]
        private string          $name,
        #[Column(nullable: true)]
        private ?string         $producerName,
        #[Embedded(class: Portion::class, columnPrefix: false)]
        private ?Portion        $portion = null,
    )
    {
        $this->proteins = $this->nutritionalValues->getProteins();
        $this->fats = $this->nutritionalValues->getFats();
        $this->carbs = $this->nutritionalValues->getCarbs();
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

    public function setNutritionalValues(NutritionalValues $newValue): void
    {
        $this->proteins = $newValue->getProteins();
        $this->fats = $newValue->getFats();
        $this->carbs = $newValue->getCarbs();
        $this->kcal = $newValue->getKcal();
    }

    public function setName(string $newName): void
    {
        $this->name = $newName;
    }

    public function setProducerName(?string $newProducerName): void
    {
        $this->producerName = $newProducerName;
    }

    public function getPortion(): ?Portion
    {
        return $this->portion;
    }

    public function setPortion(?Portion $portion): void
    {
        $this->portion = $portion;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
