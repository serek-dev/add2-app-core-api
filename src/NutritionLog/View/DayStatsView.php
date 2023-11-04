<?php

declare(strict_types=1);

namespace App\NutritionLog\View;

final class DayStatsView
{
    public readonly string $date;

    public readonly int $kcal;

    public readonly int $proteins;

    public readonly int $fats;

    public readonly int $carbs;

    private function __construct(
        string $date,
        int    $kcal,
        int    $proteins,
        int    $fats,
        int    $carbs
    )
    {
        $this->date = $date;
        $this->kcal = $kcal;
        $this->proteins = $proteins;
        $this->fats = $fats;
        $this->carbs = $carbs;
    }

    public static function fromArray(mixed $row): self
    {
        return new self(
            $row['date']->format('Y-m-d'),
            (int)$row['kcal'],
            (int)$row['proteins'],
            (int)$row['fats'],
            (int)$row['carbs'],
        );
    }
}