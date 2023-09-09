<?php

declare(strict_types=1);


namespace App\NutritionLog\View;

interface LogAbleInterface
{
    public function getProteins(): float;

    public function getFats(): float;

    public function getCarbs(): float;

    public function getKcal(): float;

    public function getWeight(): float;
}
