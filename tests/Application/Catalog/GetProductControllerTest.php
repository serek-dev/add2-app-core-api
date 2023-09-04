<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog;


use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Product\Controller\GetProductController */
final class GetProductControllerTest extends CatalogTestCase
{
    public function testICanGetOneMeal(): void
    {
        $this->iAmAuthenticated();
        $this->withPancakeMeal();

        $response = $this->iCallGetApi('/api/products/' . self::EGG);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertItemFormat($response);
        $body = json_decode($response->getContent(), true);
        $product = $body['item'];

        $this->assertSame(12.5, $product['proteins'], 'proteins');
        $this->assertSame(9.7, $product['fats'], 'fats');
        $this->assertSame(0.6, $product['carbs'], 'carbs');
        $this->assertSame(140, $product['kcal'], 'kcal');
        $this->assertSame(100, $product['weight'], 'weight');
    }

    public function testICanSeeNotFound(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallGetApi('/api/products/non-existing');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
