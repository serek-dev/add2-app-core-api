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
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('catalog_meal_product')]
class MealProduct
{
    #[Column]
    private float $weight;
    #[Column]
    private float $proteins;
    #[Column]
    private float $fats;
    #[Column]
    private float $carbs;
    #[Column]
    private float $kcal;

    #[ManyToOne(targetEntity: Meal::class, inversedBy: 'products')]
    private ?Meal $meal;

    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        Weight $weight,
        private readonly NutritionalValues $nutritionalValues,
        #[Column]
        private string  $name,
        #[Column]
        private string  $parentId,
        #[Column(nullable: true)]
        private ?string  $producerName,
        #[Embedded(class: Portion::class, columnPrefix: false)]
        private ?Portion $portion = null
    ) {
        $this->proteins = $this->nutritionalValues->getProteins();
        $this->fats = $this->nutritionalValues->getFats();
        $this->carbs = $this->nutritionalValues->getCarbs();
        $this->kcal = $this->nutritionalValues->getKcal();
        $this->weight = $weight->getRaw();
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

    public function setMeal(?Meal $meal): self
    {
        $this->meal = $meal;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWeight(): Weight
    {
        return new Weight($this->weight);
    }

    public function getProducerName(): ?string
    {
        return $this->producerName;
    }

    public function changeWeight(Weight $weight): void
    {
        $per100 = new NutritionalValues(
            new Weight($this->proteins / $this->weight * 100),
            new Weight($this->fats / $this->weight * 100),
            new Weight($this->carbs / $this->weight * 100),
            $this->kcal / $this->weight * 100
        );

        $divider = $weight->getRaw() / 100; // grams

        $new = new NutritionalValues(
            new Weight($per100->getProteins() * $divider),
            new Weight($per100->getFats() * $divider),
            new Weight($per100->getCarbs() * $divider),
            $per100->getKcal() * $divider,
        );

        $this->proteins = $new->getProteins();
        $this->fats = $new->getFats();
        $this->carbs = $new->getCarbs();
        $this->kcal = $new->getKcal();

        $this->weight = $weight->getRaw();
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }

    /** @internal */
    public function replaceByProduct(Product $product): void
    {
        $divider = $this->weight / 100;

        $this->name = $product->getName();
        $this->producerName = $product->getProducerName();
        $this->parentId = $product->getId();

        $this->proteins = $product->getNutritionValues()->getProteins() * $divider;
        $this->fats = $product->getNutritionValues()->getFats() * $divider;
        $this->carbs = $product->getNutritionValues()->getCarbs() * $divider;
        $this->kcal = $product->getNutritionValues()->getKcal() * $divider;
        $this->portion = $product->getPortion();
    }

    public function getParentId(): string
    {
        return $this->parentId;
    }

    public function getPortion(): ?Portion
    {
        return $this->portion;
    }
}
