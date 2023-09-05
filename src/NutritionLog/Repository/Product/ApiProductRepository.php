<?php

declare(strict_types=1);


namespace App\NutritionLog\Repository\Product;


use App\NutritionLog\Entity\Product;
use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\Weight;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiProductRepository implements GetOneProductInterface
{
    public function __construct(private readonly HttpClientInterface $productApi)
    {
    }

    /** @inheritDoc */
    public function getOne(string $productId): Product
    {
        $response = $this->productApi->request('GET', '/api/catalog/products/' . $productId);

        $body = $response->toArray()['item'];

        return new Product(
            id: $body['id'],
            nutritionalValues: new NutritionalValues(
                new Weight((float)$body['proteins']),
                new Weight((float)$body['fats']),
                new Weight((float)$body['carbs']),
                (float)$body['kcal'],
            ),
            name: $body['name'],
            weight: new Weight(100.0),
            producerName: $body['producerName'],
        );
    }
}
