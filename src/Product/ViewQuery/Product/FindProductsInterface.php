<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Product;

use App\Product\Exception\NotFoundException;
use App\Product\View\MealProductView;

interface FindProductsInterface
{
    /**
     * @return MealProductView[]
     */
    public function findAll(?string $name = null): array;

    /**
     * @throws NotFoundException
     */
    public function getOne(string $id): MealProductView;
}
