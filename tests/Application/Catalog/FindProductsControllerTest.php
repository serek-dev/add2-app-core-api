<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog;


use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Product\Controller\FindProductsController */
final class FindProductsControllerTest extends CatalogTestCase
{
    public function testICanFetchAListOfProducts(): void
    {
        $this->iAmAuthenticated();
        $this->withPancakeMeal();

        $response = $this->iCallGetApi('/api/products');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertCollectionFormat($response);
        $body = json_decode($response->getContent(), true);

        foreach ($body['collection'] as $product) {
            $this->assertArrayHasKey('id', $product);
            $this->assertArrayHasKey('name', $product);
            $this->assertArrayHasKey('producerName', $product);
            $this->assertArrayHasKey('proteins', $product);
            $this->assertArrayHasKey('fats', $product);
            $this->assertArrayHasKey('carbs', $product);
            $this->assertArrayHasKey('kcal', $product);
            $this->assertArrayHasKey('weight', $product);
        }

        $this->assertSame(6, $body['metadata']['count']);
    }

    public function testICanSearchByNameAndNothingFound(): void
    {
        /*
         * I am authenticated
         * And at least one product exist
         * When I try to fetch a list with a name "bleble"
         * Then it should be rendered as expected
         * And there should not be any results
         */
        $this->iAmAuthenticated();
        $this->withPancakeMeal();

        $response = $this->iCallGetApi('/api/products', ['name' => 'bleble']);

        $this->assertCollectionFormat($response);
        $body = json_decode($response->getContent(), true);
        $this->assertSame(0, $body['metadata']['count']);
    }

    public function testICanSearchByNameAndFoundMatchingPancake(): void
    {
        $this->iAmAuthenticated();
        $this->withPancakeMeal();
        $response = $this->iCallGetApi('/api/products', ['name' => 'oli']);
        $this->assertCollectionFormat($response);
        $body = json_decode($response->getContent(), true);
        $this->assertSame(1, $body['metadata']['count']);
    }
}
