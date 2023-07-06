<?php

declare(strict_types=1);


namespace App\Product\Entity;


use App\Product\Event\ProductCreated;
use App\Product\Value\NutritionalValues;
use App\Product\Value\Weight;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('product_product')]
final class Product implements AggregateRoot
{
    #[Column]
    private float $proteins;
    #[Column]
    private float $fats;
    #[Column]
    private float $carbs;
    #[Column]
    private float $kcal;

    private array $events = [];

    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private readonly string $id,
        private readonly NutritionalValues $nutritionalValues,
        #[Column]
        private readonly string $name,
        #[Column(nullable: true)]
        private readonly ?string $producerName
    ) {
        $this->proteins = $this->nutritionalValues->getProteins();
        $this->fats = $this->nutritionalValues->getFats();
        $this->carbs = $this->nutritionalValues->getCarbs();
        $this->kcal = $this->nutritionalValues->getKcal();

        $this->events[] = new ProductCreated(
            $id,
            $this->name,
            $this->proteins,
            $this->fats,
            $this->carbs,
            $this->kcal,
            $this->producerName,
        );
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

    /** @inheritDoc */
    public function pullEvents(): array
    {
        return $this->events;
    }
}
