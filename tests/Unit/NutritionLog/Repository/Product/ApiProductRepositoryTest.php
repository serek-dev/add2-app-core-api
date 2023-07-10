<?php

namespace App\Tests\Unit\NutritionLog\Repository\Product;

use App\NutritionLog\Repository\Product\ApiProductRepository;
use App\NutritionLog\Repository\Product\GetOneProductInterface;
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

        // Then it should be used with expected payload
        $client->expects($this->once())
            ->method('request')
            ->with('GET', '/api/products/p-64a466b4e03c1')
            ->willReturn($response);

        $sut = new ApiProductRepository($client);

        // And Product should be as expected
        $product = $sut->getOne($productId);
        $this->assertSame($productId, $product->getId());
        $this->assertSame('ABC', $product->getName());
    }
}
