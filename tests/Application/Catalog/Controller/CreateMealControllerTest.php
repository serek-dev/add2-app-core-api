<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog\Controller;


use App\Tests\Application\Catalog\CatalogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Catalog\Controller\CreateMealController */
final class CreateMealControllerTest extends CatalogTestCase
{
    const PRODUCTS = [
        [
            'id' => self::MILK,
            'weight' => 100.0,
        ],
        [
            'id' => self::WHEY_PROTEIN,
            'weight' => 35.0,
        ],
        [
            'id' => self::EGG,
            'weight' => 56.0,
        ],
        [
            'id' => self::OLIVE,
            'weight' => 5.0,
        ],
        [
            'id' => self::OAT_BRAN,
            'weight' => 10.0,
        ],
    ];

    public function testICanCreateACatalogMeal(): void
    {
        /*
         * I am authenticated
         * And all required products exist
         * When I try to create a new meal that does not exist yet (by its name)
         * Then I should see created status code
         */
        $this->iAmAuthenticated();

        $this->withMilk()
            ->withWheyProtein()
            ->withOlive()
            ->withOatBran()
            ->withEgg();

        $response = $this->iCallPostApi('/api/catalog/meals', [
            'id' => self::PANCAKE,
            'name' => 'Pancake',
            'products' => self::PRODUCTS,
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $response = $response->toArray();
        $this->assertArrayHasKey('item', $response);
        $this->assertArrayHasKey('id', $response['item']);
    }

    public function testICanNotCreateACatalogMealWhenNameIsAlreadyUsed(): void
    {
        /*
         * I am authenticated
         * And all required products exist
         * When I try to create a new meal that does already exist (by its name)
         * Then I should see created status code
         */
        $this->iAmAuthenticated();

        $response = $this->iCallPostApi('/api/catalog/meals', [
            'name' => 'Pancake',
            'products' => self::PRODUCTS,
        ]);

        $this->assertEquals(Response::HTTP_CONFLICT, $response->getStatusCode());
    }
}
