<?php

declare(strict_types=1);


namespace App\NutritionLog\View;


final class ProductView
{
    public function __construct(
        public readonly string $id,
        public readonly string $consumptionTime,
        public readonly string $productId,
        public readonly string $productName,
        public readonly ?string $producerName,
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
            $data['product_id'],
            $data['product_name'],
            $data['producer_name'],
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
            'productId' => $this->productId,
            'productName' => $this->productName,
            'proteins' => $this->proteins,
            'fats' => $this->fats,
            'carbs' => $this->carbs,
            'kcal' => $this->kcal,
            'weight' => $this->weight,
        ];
    }
}
