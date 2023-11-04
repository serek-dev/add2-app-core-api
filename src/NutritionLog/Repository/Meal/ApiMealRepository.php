<?php

declare(strict_types=1);


namespace App\NutritionLog\Repository\Meal;


use App\NutritionLog\Entity\Meal;
use App\NutritionLog\Entity\Product;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiMealRepository implements GetOneMealInterface
{
    public function __construct(private readonly HttpClientInterface $catalogApi)
    {
    }

    /** @inheritDoc */
    public function getOne(string $mealId): Meal
    {
        $response = $this->catalogApi->request('GET', '/api/catalog/meals/' . $mealId);

        $body = $response->toArray()['item'];

        return new Meal(
            id: $body['id'],
            name: $body['name'],
            products: array_map(fn(array $data): Product => Product::createFromArray($data), $body['products']),
        );
    }
}
