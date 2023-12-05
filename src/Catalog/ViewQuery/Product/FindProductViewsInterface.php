<?php

declare(strict_types=1);


namespace App\Catalog\ViewQuery\Product;

use App\Catalog\Exception\NotFoundException;
use App\Catalog\View\ProductView;

interface FindProductViewsInterface
{
    /**
     * @return ProductView[]
     */
    public function findAllByUserAndName(string $userId, ?string $name = null): array;

    /**
     * @throws NotFoundException
     */
    public function getOne(string $id): ProductView;
}
