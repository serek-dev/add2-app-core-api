<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog\Controller;


use App\Tests\Application\Catalog\CatalogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Catalog\Controller\FindMealsController */
final class FindMealsControllerTest extends CatalogTestCase
{
    public function testICanFetchAListOfMeals(): void
    {
        /*
         * I am authenticated
         * And at least one meal exist
         * When I try to fetch a list
         * Then it should be rendered as expected
         * And nutrition values should be a sum of products
         */
        $this->iAmAuthenticated();
        $this->withPancakeMeal();

        $response = $this->iCallGetApi('/api/catalog/meals');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertCollectionFormat($response);
        $body = json_decode($response->getContent(), true);

        foreach ($body['collection'] as $meal) {
            $sumProteins = 0.0;
            $sumFats = 0.0;
            $sumCarbs = 0.0;
            $sumKcal = 0.0;

            foreach ($meal['products'] as $product) {
                $sumProteins += $product['proteins'];
                $sumFats += $product['fats'];
                $sumCarbs += $product['carbs'];
                $sumKcal += $product['kcal'];
            }

            $this->assertSame(40.1, $sumProteins, 'proteins');
            $this->assertSame(14.16, $sumFats, 'fats');
            $this->assertSame(12.62, $sumCarbs, 'carbs');
            $this->assertSame(341.35, $sumKcal, 'kcal');

            $this->assertSame(40.1, $meal['proteins'], 'proteins');
            $this->assertSame(14.16, $meal['fats'], 'fats');
            $this->assertSame(12.62, $meal['carbs'], 'carbs');
            $this->assertSame(341.35, $meal['kcal'], 'kcal');
        }
    }

    public function testICanSearchByNameAndNothingFound(): void
    {
        /*
         * I am authenticated
         * And at least one meal exist
         * When I try to fetch a list with a name "bleble"
         * Then it should be rendered as expected
         * And there should not be any results
         */
        $this->iAmAuthenticated();
        $this->withPancakeMeal();

        $response = $this->iCallGetApi('/api/catalog/meals', ['name' => 'bleble']);

        $this->assertCollectionFormat($response);
        $body = json_decode($response->getContent(), true);
        $this->assertSame(0, $body['metadata']['count']);
    }

    public function testICanSearchByNameAndFoundMatchingPancake(): void
    {
        $this->iAmAuthenticated();
        $this->withPancakeMeal();
        $response = $this->iCallGetApi('/api/catalog/meals', ['name' => 'pan']);
        $this->assertCollectionFormat($response);
        $body = json_decode($response->getContent(), true);
        $this->assertSame(1, $body['metadata']['count']);
    }
}
