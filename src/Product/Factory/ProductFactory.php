<?php

declare(strict_types=1);


namespace App\Product\Factory;


use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Entity\Product;

final class ProductFactory
{
    public function create(CreateProductDtoInterface $createProductDto): Product
    {
        return new Product(
            $createProductDto->getNutritionValues(),
            $createProductDto->getName(),
            $createProductDto->getProducerName(),
        );
    }
}
