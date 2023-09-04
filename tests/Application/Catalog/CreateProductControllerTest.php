<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog;


use App\Tests\Application\ApplicationTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Product\Controller\CreateProductController */
final class CreateProductControllerTest extends ApplicationTestCase
{
    public function testCreateSuccessfully(): void
    {
        // When I try to create a new product that does not exist yet
        $response = $this->client->request('POST', '/api/products', [
            'json' => [
                'name' => 'fake product',
                'proteins' => 12.0,
                'fats' => 7.2,
                'carbs' => 62.0,
                'kcal' => 375,
                'producerName' => 'producer',
            ],
        ]);

        // Then I should see created status code
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testFailsOnDuplication(): void
    {
        // When I try to create a new product that does not exist yet
        $response = $this->client->request('POST', '/api/products', [
            'json' => [
                'name' => 'fake product',
                'proteins' => 12.0,
                'fats' => 7.2,
                'carbs' => 62.0,
                'kcal' => 375,
                'producerName' => 'producer',
            ],
        ]);

        // Then I should see conflict status code
        $this->assertEquals(Response::HTTP_CONFLICT, $response->getStatusCode());
    }
}
