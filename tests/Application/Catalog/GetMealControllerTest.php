<?php

declare(strict_types=1);


namespace App\Tests\Application\Catalog;


use Symfony\Component\HttpFoundation\Response;

/** @covers \App\Product\Controller\GetMealController */
final class GetMealControllerTest extends CatalogTestCase
{
    public function testICanGetOneMeal(): void
    {
        $this->iAmAuthenticated();
        $this->withPancakeMeal();

        $response = $this->iCallGetApi('/api/meals/' . self::PANCAKE);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertItemFormat($response);
        $body = json_decode($response->getContent(), true);
        $meal = $body['item'];

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

    public function testICanSeeNotFound(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallGetApi('/api/meals/non-existing');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
