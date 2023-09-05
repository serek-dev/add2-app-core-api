<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\ProductDetail;
use App\NutritionLog\Value\Weight;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('nutrition_log_day_meal_product')]
final class DayMealProduct
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

    #[ManyToOne(targetEntity: DayMeal::class, inversedBy: 'products')]
    private DayMeal $meal;

    #[Column]
    private string $productId;
    #[Column]
    private string $productName;
    #[Column(nullable: true)]
    private ?string $producerName;

    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        Weight $weight,
        private NutritionalValues $nutritionalValues,
        private ProductDetail $original,
    ) {
        $this->proteins = $this->nutritionalValues->getProteins()->getRaw();
        $this->fats = $this->nutritionalValues->getFats()->getRaw();
        $this->carbs = $this->nutritionalValues->getCarbs()->getRaw();
        $this->kcal = $this->nutritionalValues->getKcal();
        $this->weight = $weight->getRaw();

        $this->productId = $this->original->getOriginalProductId();
        $this->productName = $this->original->getOriginalProductName();
        $this->producerName = $this->original->getOriginalProducerName();
    }

    public function setMeal(DayMeal $value): void
    {
        $this->meal = $value;
    }
}
