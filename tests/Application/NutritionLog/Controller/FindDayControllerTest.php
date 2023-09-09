<?php

declare(strict_types=1);


namespace App\Tests\Application\NutritionLog\Controller;


use App\Tests\Application\NutritionLog\NutritionLogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\NutritionLog\Controller\FindDayController */
final class FindDayControllerTest extends NutritionLogTestCase
{
    public function testICanFindADayEvenIfItDoesNotExist(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallGetApi('/api/nutrition-log/2018-01-01');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertItemFormat($response);
    }

    public function testICanFindAnExistingDay(): void
    {
        $this->iAmAuthenticated();

        $day = '2021-01-01';

        $this->withPancakeMeal()
            ->withMealInNutritionLog($day, '10:45', parent::PANCAKE)
            ->withEgg()
            ->withProductInNutritionLog($day, '10:45', parent::EGG, 100);

        $response = $this->iCallGetApi("/api/nutrition-log/${day}");

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertItemFormat($response);

        $body = json_decode($response->getContent(), true);
        $data = $body['item'];

        $this->assertSame($day, $data['date']);

        // Item nutrition values should be a sum of all products and meals
        $sumProteins = 0.0;
        $sumFats = 0.0;
        $sumCarbs = 0.0;
        $sumKcal = 0.0;

        foreach ($data['products'] as $consumptionTime => $products) {
            foreach ($products as $product) {
                $sumProteins += $product['proteins'];
                $sumFats += $product['fats'];
                $sumCarbs += $product['carbs'];
                $sumKcal += $product['kcal'];

                // Each product and meal should have consumption date
                $this->assertArrayHasKey('consumptionTime', $product);

                if (isset($product['products'])) {
                    foreach ($product['products'] as $meal) {
                        $this->assertArrayNotHasKey('consumptionTime', $meal);
                    }
                }
            }
        }

        $this->assertSame($data['proteins'], round($sumProteins, 2), 'proteins');
        $this->assertSame($data['fats'], round($sumFats, 2), 'fats');
        $this->assertSame($data['carbs'], round($sumCarbs, 2), 'carbs');
        $this->assertSame($data['kcal'], round($sumKcal, 2), 'kcal');
    }
}
