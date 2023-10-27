<?php

declare(strict_types=1);

namespace App\Catalog\Specification;

use App\Catalog\Entity\Product;
use Throwable;

interface ProductSpecificationInterface
{
    /** @throws Throwable - on false */
    public function isSatisfiedBy(Product $product): bool;
}