<?php

declare(strict_types=1);

namespace App\Catalog\Specification\Product;

use App\Catalog\Entity\Product;
use App\Catalog\Exception\DuplicateException;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Specification\ProductSpecificationInterface;

final class UniqueIdSpecification implements ProductSpecificationInterface
{
    public function __construct(
        private readonly FindProductByIdInterface $find,
    )
    {
    }

    public function isSatisfiedBy(Product $product): bool
    {
        if ($this->find->findById($id = $product->getId())) {
            throw new DuplicateException(
                "Product with id: $id already exist"
            );
        }

        return true;
    }
}