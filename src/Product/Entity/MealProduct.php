<?php

declare(strict_types=1);


namespace App\Product\Entity;


use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('product_meal_product')]
final class MealProduct
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
    private Meal $meal;

    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        Weight $weight,
        private readonly NutritionalValues $nutritionalValues,
        #[Column]
        private readonly string $name,
        #[Column]
        private readonly string $parentId,
        #[Column(nullable: true)]
        private readonly ?string $producerName
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

    public function setMeal(Meal $meal): void
    {
        $this->meal = $meal;
    }
}
