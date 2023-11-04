<?php

declare(strict_types=1);


namespace App\NutritionLog\Repository\Meal;


use App\NutritionLog\Entity\Meal;
use App\NutritionLog\Entity\Product;
use App\NutritionLog\Value\NutritionalValues;
use App\NutritionLog\Value\Portion;
use App\NutritionLog\Value\Weight;
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
            products: array_map(function (array $data): Product {
                return new Product(
                    id: $data['id'],
                    nutritionalValues: new NutritionalValues(
                        proteins: new Weight($data['proteins']),
                        fats: new Weight($data['fats']),
                        carbs: new Weight($data['carbs']),
                        kcal: $data['kcal'],
                    ),
                    name: $data['name'],
                    weight: new Weight((float)$data['weight']),
                    producerName: $data['producerName'],
                    portion: isset($data['unit']) && isset($data['weightPerUnit']) ? new Portion($data['unit'], $data['weightPerUnit']) : null,
                );
            }, $body['products']),
        );
    }
}
