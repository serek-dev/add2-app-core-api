<?php

declare(strict_types=1);


namespace App\Catalog\ViewQuery\Product;

use App\Catalog\Exception\NotFoundException;
use App\Catalog\View\ProductView;

interface FindProductsInterface
{
    /**
     * @return ProductView[]
     */
    public function findAll(?string $name = null): array;

    /**
     * @throws NotFoundException
     */
    public function getOne(string $id): ProductView;
}
