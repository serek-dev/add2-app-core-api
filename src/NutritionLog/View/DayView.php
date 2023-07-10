<?php

declare(strict_types=1);


namespace App\NutritionLog\View;


use JsonSerializable;

final class DayView implements JsonSerializable
{
    private array $stats = [
        'proteins' => 0.0,
        'fats' => 0.0,
        'carbs' => 0.0,
        'kcal' => 0.0,
        'mealsCount' => 0,
        'weight' => 0.0,
    ];

    private array $products = [];
    private array $meals = [];

    private string $date;

    public function jsonSerialize(): array
    {
        return [
            'date' => $this->date,
            'sum' => $this->stats,
            'products' => $this->products,
            'meals' => $this->meals,
        ];
    }

    public function setStats(array $stats): self
    {
        $this->stats = $stats;
        return $this;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function setProducts(array $products): self
    {
        $this->products = $products;
        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getMeals(): array
    {
        return $this->meals;
    }

    public function setMeals(array $meals): DayView
    {
        $this->meals = $meals;
        return $this;
    }
}
