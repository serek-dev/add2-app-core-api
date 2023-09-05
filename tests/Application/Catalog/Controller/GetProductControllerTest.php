<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog\Controller;


use App\Tests\Application\Catalog\CatalogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Catalog\Controller\GetProductController */
final class GetProductControllerTest extends CatalogTestCase
{
    public function testICanGetOneProduct(): void
    {
        $this->iAmAuthenticated();
        $this->withPancakeMeal();

        $response = $this->iCallGetApi('/api/catalog/products/' . self::EGG);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertItemFormat($response);
        $body = json_decode($response->getContent(), true);
        $product = $body['item'];

        $this->assertSame(12.5, $product['proteins'], 'proteins');
        $this->assertSame(9.7, $product['fats'], 'fats');
        $this->assertSame(0.6, $product['carbs'], 'carbs');
        $this->assertSame(140, $product['kcal'], 'kcal');
    }

    public function testICanSeeNotFound(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallGetApi('/api/catalog/products/non-existing');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
