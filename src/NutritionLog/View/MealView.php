<?php

declare(strict_types=1);


namespace App\NutritionLog\View;


use JsonSerializable;

final class MealView implements JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $consumptionTime,
        public readonly string $productName,
        public readonly float $proteins,
        public readonly float $fats,
        public readonly float $carbs,
        public readonly float $kcal,
        public readonly float $weight,
    ) {
    }

    public static function fromArray(array $data)
    {
        return new self(
            $data['id'],
            $data['consumption_time'],
            $data['name'],
            (float)$data['proteins'],
            (float)$data['fats'],
            (float)$data['carbs'],
            (float)$data['kcal'],
            (float)$data['weight'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'consumptionTime' => $this->consumptionTime,
            'productName' => $this->productName,
            'proteins' => $this->proteins,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
            'kcal' => $this->kcal,
            'weight' => $this->weight,
        ];
    }
}
