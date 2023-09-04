<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog;


use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Product\Controller\CreateProductController */
final class CreateProductControllerTest extends CatalogTestCase
{
    public function testICanCreateACatalogProduct(): void
    {
        /*
         * I am authenticated
         * When I try to create a new product that does not exist yet
         * Then I should see created status code
         */
        $this->iAmAuthenticated();

        $response = $this->iCallPostApi('/api/products', [
            'name' => 'fake product',
            'proteins' => 12.0,
            'fats' => 7.2,
            'carbs' => 62.0,
            'kcal' => 375,
            'producerName' => 'producer',
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testICanNotCreateACatalogProductWhenNameIsAlreadyUsed(): void
    {
        /*
         * I am authenticated
         * When I try to create a new product that does exist already with the same name
         * Then I should see conflict status code
         */
        $this->iAmAuthenticated();

        $response = $this->iCallPostApi('/api/products', [
            'name' => 'fake product',
            'proteins' => 12.0,
            'fats' => 7.2,
            'carbs' => 62.0,
            'kcal' => 375,
            'producerName' => 'producer',
        ]);

        $this->assertEquals(Response::HTTP_CONFLICT, $response->getStatusCode());
    }
}
