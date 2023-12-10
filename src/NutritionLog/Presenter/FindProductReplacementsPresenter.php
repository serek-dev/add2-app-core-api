<?php

declare(strict_types=1);


namespace App\NutritionLog\Presenter;


use App\NutritionLog\Exception\NotFoundException;
use App\NutritionLog\Repository\Product\FindAllProductsInterface;
use App\NutritionLog\ViewQuery\Day\FindDayViewInterface;

final class FindProductReplacementsPresenter
{
    public function __construct(
        private readonly FindDayViewInterface     $findDayById,
        private readonly FindAllProductsInterface $findAllProducts,
    )
    {
    }

    public function render(string $date, string $productId, string $userId): array
    {
        $day = $this->findDayById->findByDateAndUser($date, $userId);

        $replacedProduct = null;

        foreach ($day->getProducts() as $dayProduct) {
            if ($dayProduct->id === $productId) {
                $replacedProduct = $dayProduct;
                break;
            }
        }

        if (!$replacedProduct) {
            throw new NotFoundException('Unable to find nutrition log product: ' . $productId);
        }

        // All products with its nutrition per 100g
        $result = $this->findAllProducts->findAllByUser($userId);

        // Computed replacements
        $replacementProducts = [];

        $desiredKcal = $replacedProduct->getKcal();

        foreach ($result as $product) {
            if ($product->getId() === $replacedProduct->productId) {
                continue;
            }
            $caloriesPer100g = $product->getNutritionValues()->getKcal();

            // Calculate the amount of this product needed to reach the desired calories
            $amountNeeded = round(($desiredKcal) / ($caloriesPer100g) * 100, 2);

            // Store the replacement product information in the array
            $replacementProducts[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'producerName' => $product->getProducerName(),
                'weight' => $amountNeeded,
            ];
        }

        return [
            'collection' => $replacementProducts,
            'metadata' => [
                'replacedProductId' => $replacedProduct->id,
                'replacedOriginalProductId' => $replacedProduct->productId,
                'replacedProductName' => $replacedProduct->productName,
                'replacedProductWeight' => $replacedProduct->getWeight(),
                'replacedProductKcal' => $desiredKcal,
                'count' => count($replacementProducts),
            ],
        ];
    }
}
