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
class DayMealProduct
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

    public function getId(): string
    {
        return $this->id;
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
            new Weight($per100->getProteins()->getRaw() * $divider),
            new Weight($per100->getFats()->getRaw() * $divider),
            new Weight($per100->getCarbs()->getRaw() * $divider),
            $per100->getKcal() * $divider,
        );

        $this->proteins = $new->getProteins()->getRaw();
        $this->fats = $new->getFats()->getRaw();
        $this->carbs = $new->getCarbs()->getRaw();
        $this->kcal = $new->getKcal();

        $this->weight = $weight->getRaw();
    }

    public function replaceByProduct(Product $product): void
    {
        $divider = $this->weight / 100;

        $this->productName = $product->getName();
        $this->producerName = $product->getProducerName();

        $this->proteins = $product->getNutritionValues()->getProteins()->getRaw() * $divider;
        $this->fats = $product->getNutritionValues()->getFats()->getRaw() * $divider;
        $this->carbs = $product->getNutritionValues()->getCarbs()->getRaw() * $divider;
        $this->kcal = $product->getNutritionValues()->getKcal() * $divider;

        $this->productId = $product->getId();
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }
}
