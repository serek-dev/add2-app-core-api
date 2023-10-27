<?php

declare(strict_types=1);

namespace App\Catalog\Specification\Product;

use App\Catalog\Entity\Product;
use App\Catalog\Exception\InvalidArgumentException;
use App\Catalog\Specification\ProductSpecificationInterface;
use DivisionByZeroError;
use function abs;
use function round;

final class NutritionMistakeThresholdSpecification implements ProductSpecificationInterface
{
    private const PROTEIN_KCAL_PER_G = 4;
    private const FAT_KCAL_PER_G = 9;
    private const CARBS_KCAL_PER_G = 4;

    // we allow some mistake threshold, as some nutrition's tables
    // adds some calories from fibre for example, and we do not support it
    private const KCAL_MISTAKE_THRESHOLD_PERCENTAGE = 10;

    public function isSatisfiedBy(Product $product): bool
    {
        $proteinsKcal = (self::PROTEIN_KCAL_PER_G * $product->getNutritionValues()->getProteins());
        $fatKcal = (self::FAT_KCAL_PER_G * $product->getNutritionValues()->getFats());
        $carbsKcal = (self::CARBS_KCAL_PER_G * $product->getNutritionValues()->getCarbs());

        $calculatedKcal = $proteinsKcal + $fatKcal + $carbsKcal;
        $actualKcal = $product->getNutritionValues()->getKcal();

        try {
            $diffPercentage = round(abs(($calculatedKcal - $actualKcal) / (($calculatedKcal + $actualKcal) / 2)) * 100);
        } catch (DivisionByZeroError $e) {
            $diffPercentage = 0;
        }

        if ($diffPercentage > self::KCAL_MISTAKE_THRESHOLD_PERCENTAGE) {
            throw new InvalidArgumentException(
                'Invalid kcal value. Difference should not be more than: ' . self::KCAL_MISTAKE_THRESHOLD_PERCENTAGE . '%, it is: ' . $diffPercentage . '% now'
            );
        }

        return true;
    }
}