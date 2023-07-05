<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Product;

use App\Product\View\ProductView;

interface FindProductsInterface
{
    /**
     * @return ProductView[]
     */
    public function findAll(?string $name = null): array;
}