<?php

declare(strict_types=1);

namespace App\Catalog\Specification\Product;

use App\Catalog\Entity\Product;
use App\Catalog\Exception\DuplicateException;
use App\Catalog\Persistence\Product\FindProductByNameInterface;
use App\Catalog\Specification\ProductSpecificationInterface;

final class UniqueNameSpecification implements ProductSpecificationInterface
{
    public function __construct(
        private readonly FindProductByNameInterface $find,
    )
    {
    }

    public function isSatisfiedBy(Product $product): bool
    {
        if ($this->find->findByName($name = $product->getName(), $product->getProducerName())) {
            throw new DuplicateException(
                "Product with name: $name already exist"
            );
        }

        return true;
    }
}