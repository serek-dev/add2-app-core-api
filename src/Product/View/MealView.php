<?php

declare(strict_types=1);


namespace App\Product\View;


use App\Product\Entity\MealProduct;
use JsonSerializable;

final class MealView implements JsonSerializable
{
    private string $id;

    private string $name;

    private float $proteins;

    private float $fats;

    private float $carbs;

    private float $kcal;

    private float $weight;

    /**
     * @var MealProduct[]
     */
    private array $products = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getProteins(): float
    {
        return $this->proteins;
    }

    public function setProteins(float $proteins): self
    {
        $this->proteins = $proteins;
        return $this;
    }

    public function getFats(): float
    {
        return $this->fats;
    }

    public function setFats(float $fats): self
    {
        $this->fats = $fats;
        return $this;
    }

    public function getCarbs(): float
    {
        return $this->carbs;
    }

    public function setCarbs(float $carbs): self
    {
        $this->carbs = $carbs;
        return $this;
    }

    public function getKcal(): float
    {
        return $this->kcal;
    }

    public function setKcal(float $kcal): self
    {
        $this->kcal = $kcal;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'proteins' => $this->proteins,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
            'kcal' => $this->kcal,
            'weight' => $this->weight,
            'products' => array_map(fn(JsonSerializable $v) => $v->jsonSerialize(), $this->getProducts()),
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

    /**
     * @param MealProduct[] $products
     */
    public function setProducts(array $products): self
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return ProductView[]
     */
    public function getProducts(): array
    {
        return array_map(function (MealProduct $p) {
            $view = new ProductView();

            $v = $p->getNutritionValues();

            $view->setId($p->getId())
                ->setName($p->getName())
                ->setCarbs($v->getCarbs())
                ->setProteins($v->getProteins())
                ->setFats($v->getFats())
                ->setWeight($p->getWeight()->getRaw())
                ->setKcal($v->getKcal());

            return $view;
        }, $this->products);
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }
}
