<?php

declare(strict_types=1);


namespace App\Product\Factory;


use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Entity\Product;
use App\Product\Exception\DuplicateException;
use App\Product\Repository\Product\FindProductByNameInterface;

final class ProductFactory
{
    public function __construct(private readonly FindProductByNameInterface $findProductByName)
    {
    }

    public function create(CreateProductDtoInterface $createProductDto): Product
    {
        if ($this->findProductByName->findByName($createProductDto->getName(), $createProductDto->getProducerName())) {
            throw new DuplicateException(
                "Product with name: {$createProductDto->getName()} and produced by: {$createProductDto->getProducerName()} already exist"
            );
        }

        return new Product(
            uniqid('p-'),
            $createProductDto->getNutritionValues(),
            $createProductDto->getName(),
            $createProductDto->getProducerName(),
        );
    }
}
