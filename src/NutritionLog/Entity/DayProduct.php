<?php

declare(strict_types=1);


namespace App\NutritionLog\Entity;


use App\NutritionLog\Value\ConsumptionTime;
use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\ProductDetail;
use App\NutritionLog\Value\Weight;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('nutrition_log_day_product')]
final class DayProduct
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

    #[ManyToOne(targetEntity: Day::class, inversedBy: 'products')]
    private Day $day;

    #[Column]
    private string $productId;
    #[Column]
    private string $productName;
    #[Column(nullable: true)]
    private ?string $producerName;
    #[Column]
    private string $consumptionTime;

    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        Weight $weight,
        private NutritionalValues $nutritionalValues,
        ConsumptionTime $consumptionTime,
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

        $this->consumptionTime = (string)$consumptionTime;
    }

    public function setDay(Day $day): void
    {
        $this->day = $day;
    }

    public function getConsumptionTime(): ConsumptionTime
    {
        return new ConsumptionTime(new DateTimeImmutable($this->consumptionTime));
    }
}
