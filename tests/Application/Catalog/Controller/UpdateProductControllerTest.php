<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog\Controller;


use App\Shared\DataFixtures\ProductFixtures;
use App\Tests\Application\Catalog\CatalogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Catalog\Controller\UpdateProductController */
final class UpdateProductControllerTest extends CatalogTestCase
{
    public function testICanSeeNotFound(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallPutApi('/api/catalog/products/non-existing', [
            'name' => 'fake product',
            'proteins' => 12.0,
            'fats' => 7.2,
            'carbs' => 62.0,
            'kcal' => 375,
            'producerName' => 'producer',
        ]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testICanUpdateCatalogProduct(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallPutApi('/api/catalog/products/' . ProductFixtures::PRODUCT_2, [
            'name' => 'fake product',
            'proteins' => 1.0,
            'fats' => 1.0,
            'carbs' => 1.0,
            'kcal' => 17.0,
            'producerName' => 'producer',
        ]);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
