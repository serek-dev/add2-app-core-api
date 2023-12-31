<?php

declare(strict_types=1);


namespace App\NutritionLog\Repository\Product;


use App\NutritionLog\Entity\Product;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiProductRepository implements GetOneProductInterface, FindAllProductsInterface
{
    public function __construct(private readonly HttpClientInterface $catalogApi)
    {
    }

    /** @inheritDoc */
    public function getOne(string $productId): Product
    {
        $response = $this->catalogApi->request('GET', '/api/catalog/products/' . $productId);

        $body = $response->toArray()['item'];

        return Product::createFromArray($body);
    }

    /** @inheritdoc */
    public function findAll(): array
    {
        $response = $this->catalogApi->request('GET', '/api/catalog/products');

        $body = $response->toArray()['collection'];

        return array_map(fn(array $resp) => Product::createFromArray($resp), $body);
    }
}
