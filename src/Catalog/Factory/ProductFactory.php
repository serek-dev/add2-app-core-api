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
    private const PROTEIN_KCAL_PER_G = 4;
    private const FAT_KCAL_PER_G = 9;
    private const CARBS_KCAL_PER_G = 4;

    // we allow some mistake threshold, as some nutrition's tables
    // adds some calories from fibre for example, and we do not support it
    private const KCAL_MISTAKE_THRESHOLD_PERCENTAGE = 10;

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
            $id,
            $createProductDto->getNutritionValues(),
            $createProductDto->getName(),
            $createProductDto->getProducerName(),
        );

        foreach ($this->specifications as $spec) {
            $spec->isSatisfiedBy($product);
        }

        return $product;
    }
}
