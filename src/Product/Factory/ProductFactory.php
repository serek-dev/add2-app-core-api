<?php

declare(strict_types=1);


namespace App\Product\Factory;


use App\Product\Dto\CreateProductDtoInterface;
use App\Product\Entity\Product;
use App\Product\Exception\DuplicateException;
use App\Product\Exception\InvalidArgumentException;
use App\Product\Persistence\Product\FindProductByNameInterface;

final class ProductFactory
{
    private const PROTEIN_KCAL_PER_G = 4;
    private const FAT_KCAL_PER_G = 9;
    private const CARBS_KCAL_PER_G = 4;

    // we allow some mistake threshold, as some nutrition's tables
    // adds some calories from fibre for example, and we do not support it
    private const KCAL_MISTAKE_THRESHOLD_PERCENTAGE = 10;

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

        $proteinsKcal = (self::PROTEIN_KCAL_PER_G * $createProductDto->getNutritionValues()->getProteins());
        $fatKcal = (self::FAT_KCAL_PER_G * $createProductDto->getNutritionValues()->getFats());
        $carbsKcal = (self::CARBS_KCAL_PER_G * $createProductDto->getNutritionValues()->getCarbs());

        $calculatedKcal = $proteinsKcal + $fatKcal + $carbsKcal;
        $actualKcal = $createProductDto->getNutritionValues()->getKcal();

        $diffPercentage = round(abs(($calculatedKcal - $actualKcal) / (($calculatedKcal + $actualKcal) / 2)) * 100);

        if ($diffPercentage > self::KCAL_MISTAKE_THRESHOLD_PERCENTAGE) {
            throw new InvalidArgumentException(
                'Invalid kcal value. Difference should not be more than: ' . self::KCAL_MISTAKE_THRESHOLD_PERCENTAGE . '%, it is: ' . $diffPercentage . '% now'
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
