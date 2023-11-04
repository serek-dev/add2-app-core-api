<?php

namespace App\Tests\Unit\NutritionLog\Repository\Product;

use App\NutritionLog\Entity\Product;
use App\NutritionLog\Repository\Product\ApiProductRepository;
use App\NutritionLog\Repository\Product\FindAllProductsInterface;
use App\NutritionLog\Repository\Product\GetOneProductInterface;
use App\NutritionLog\Value\Weight;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/** @covers \App\NutritionLog\Repository\Product\ApiProductRepository */
final class ApiProductRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new ApiProductRepository(
            $this->createMock(HttpClientInterface::class)
        );
        $this->assertInstanceOf(GetOneProductInterface::class, $sut);
        $this->assertInstanceOf(FindAllProductsInterface::class, $sut);
    }

    public function testGet(): void
    {
        // Given I have a product ID
        $productId = 'p-64a466b4e03c1';

        // And http client
        $client = $this->createMock(HttpClientInterface::class);

        // That should return valid json response
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')
            ->willReturn(
                json_decode(
                    '{
    "item": {
        "id": "p-64a466b4e03c1",
        "name": "ABC",
        "producerName": null,
        "proteins": 5,
        "fats": 10,
        "carbs": 5,
        "kcal": 40,
        "weight": 100
    }
}',
                    true
                )
            );

        // Then it should be used with the expected payload
        $client->expects($this->once())
            ->method('request')
            ->with('GET', '/api/catalog/products/p-64a466b4e03c1')
            ->willReturn($response);

        $sut = new ApiProductRepository($client);

        // And Product should be as expected
        $product = $sut->getOne($productId);
        $this->assertSame($productId, $product->getId());
        $this->assertSame('ABC', $product->getName());
    }

    public function testFindAll(): void
    {
        // Given http client
        $client = $this->createMock(HttpClientInterface::class);

        // That should return a valid json response
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')
            ->willReturn(
                json_decode(
                    '{
   "collection": [
        {
            "id": "p-64abe7897e3c8",
            "name": "Egg",
            "producerName": null,
            "proteins": 12.5,
            "fats": 9.7,
            "carbs": 0.6,
            "kcal": 140
        },
        {
            "id": "p-64fcd24141e65",
            "name": "fake product",
            "producerName": "producer",
            "proteins": 12,
            "fats": 7.2,
            "carbs": 62,
            "kcal": 375
        }]
}',
                    true
                )
            );

        // Then it should be used with the expected payload
        $client->expects($this->once())
            ->method('request')
            ->with('GET', '/api/catalog/products')
            ->willReturn($response);

        $sut = new ApiProductRepository($client);

        // And Product should be as expected
        $products = $sut->findAll();

        foreach ($products as $p) {
            $this->assertInstanceOf(Product::class, $p);
            // if there is no weight attribute, it should return 100 as weight
            $this->assertEquals(new Weight(100.0), $p->getWeight());
        }
    }
}
