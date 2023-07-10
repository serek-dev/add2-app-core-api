<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Meal;

use App\Product\Exception\NotFoundException;
use App\Product\View\MealView;

interface GetOneMealInterface
{
    /** @throws NotFoundException */
    public function getOne(string $id): MealView;
}
