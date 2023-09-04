<?php

declare(strict_types=1);


namespace App\Catalog\ViewQuery\Meal;

use App\Catalog\Exception\NotFoundException;
use App\Catalog\View\MealView;

interface GetOneMealInterface
{
    /** @throws NotFoundException */
    public function getOne(string $id): MealView;
}
