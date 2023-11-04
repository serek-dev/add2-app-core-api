<?php

declare(strict_types=1);

namespace App\NutritionLog\View;

use JetBrains\PhpStorm\ArrayShape;

final class DayStatsView
{

    private function __construct(
        public readonly string $date,
        public readonly int    $kcal,
        public readonly int    $proteins,
        public readonly int    $fats,
        public readonly int    $carbs,
        public readonly int    $kcalTarget,
        public readonly int    $proteinsTarget,
        public readonly int    $fatsTarget,
        public readonly int    $carbsTarget,
        public readonly int    $weight,
    )
    {
    }

    #[ArrayShape([
        'date' => "string",
        'kcal' => "int|string",
        'proteins' => "int|string",
        'fats' => "int|string",
        'carbs' => "int|string",
        'targetKcal' => "int|string",
        'targetProteins' => "int|string",
        'targetFats' => "int|string",
        'targetCarbs' => "int|string",
        'weight' => "int|string",
    ])]
    public static function fromArray(array $row): self
    {
        return new self(
            $row['date'],

            (int)$row['kcal'],
            (int)$row['proteins'],
            (int)$row['fats'],
            (int)$row['carbs'],

            (int)$row['targetKcal'],
            (int)$row['targetProteins'],
            (int)$row['targetFats'],
            (int)$row['targetCarbs'],

            (int)$row['weight'],
        );
    }
}