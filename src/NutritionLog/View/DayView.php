<?php

declare(strict_types=1);


namespace App\NutritionLog\View;


use JsonSerializable;

final class DayView implements JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $date,
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
            (string)$data['id'],
            $data['date'],
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
            'date' => $this->date,
            'proteins' => $this->proteins,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
            'kcal' => $this->kcal,
            'weight' => $this->weight,
        ];
    }
}