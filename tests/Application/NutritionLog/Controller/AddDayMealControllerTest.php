<?php

declare(strict_types=1);


namespace App\Tests\Application\NutritionLog\Controller;


use App\Tests\Application\NutritionLog\NutritionLogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\NutritionLog\Controller\AddDayMealController */
final class AddDayMealControllerTest extends NutritionLogTestCase
{
    public function testICanAddAMealToNonExistingDay(): void
    {
        $this->withPancakeMeal();
        $this->iAmAuthenticated();
        $response = $this->iCallPostApi('/api/nutrition-log/2020-01-01/meals', [
            'consumptionTime' => '10:15',
            'mealId' => self::PANCAKE,
            'productWeight' => 50.0,
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testICanAddAMealToExistingDay(): void
    {
        $this->withPancakeMeal();
        $this->iAmAuthenticated();
        $response = $this->iCallPostApi('/api/nutrition-log/2020-01-01/meals', [
            'consumptionTime' => '10:15',
            'mealId' => self::PANCAKE,
            'productWeight' => 50.0,
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}
