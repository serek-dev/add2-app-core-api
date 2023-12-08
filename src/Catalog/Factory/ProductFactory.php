<?php

declare(strict_types=1);


namespace App\Catalog\Factory;


use App\Catalog\Dto\CreateProductDtoInterface;
use App\Catalog\Entity\Product;
use App\Catalog\Specification\ProductSpecificationInterface;
use RuntimeException;
use Throwable;
use function uniqid;

final class ProductFactory
{
    /**
     * @param ProductSpecificationInterface[] $specifications
     */
    public function __construct(
        private readonly iterable $specifications = [],
    )
    {
        foreach ($this->specifications as $s) {
            if (!$s instanceof ProductSpecificationInterface) {
                throw new RuntimeException(
                    'Specification should implement ProductSpecificationInterface'
                );
            }
        }
    }

    /**
     * @throws Throwable
     */
    public function create(CreateProductDtoInterface $createProductDto): Product
    {
        $id = $createProductDto->getId() ?? uniqid('P-');

        $product = new Product(
            id: $id,
            nutritionalValues: $createProductDto->getNutritionValues(),
            userId: $createProductDto->getUserId(),
            name: $createProductDto->getName(),
            producerName: $createProductDto->getProducerName(),
            portion: $createProductDto->getPortion(),
        );

        foreach ($this->specifications as $spec) {
            $spec->isSatisfiedBy($product);
        }

        return $product;
    }
}
