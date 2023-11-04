<?php

declare(strict_types=1);


namespace App\Tests\Application\NutritionLog\Controller;


use App\Tests\Application\NutritionLog\NutritionLogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\NutritionLog\Controller\RemoveDayProductsByConsumptionTimeController */
final class RemoveDayProductsByConsumptionTimeControllerTest extends NutritionLogTestCase
{
    public function testICanSeeNotFoundErrorWhenThereIsSuchDay(): void
    {
        $this->iAmAuthenticated();

        $day = '2021-01-02';

        $response = $this->iCallDeleteApi("/api/nutrition-log/days/${day}/12:00");

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testICanRemoveAllProductsAndMealsFromAGivenConsumptionTime(): void
    {
        $this->iAmAuthenticated();

        $day = '2021-01-02';

        $this->withPancakeMeal()
            ->withMealInNutritionLog($day, '10:45', parent::PANCAKE)
            ->withEgg()
            ->withProductInNutritionLog($day, '10:45', parent::EGG, 100);

        $response = $this->iCallDeleteApi("/api/nutrition-log/days/${day}/10:45");

        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
    }

    /** @depends testICanRemoveAllProductsAndMealsFromAGivenConsumptionTime */
    public function testICanSeeNotFoundErrorWhenThereIsNoMealInGivenConsumptionTime(): void
    {
        usleep(1000);

        $this->iAmAuthenticated();

        $day = '2021-01-02';

        $response = $this->iCallDeleteApi("/api/nutrition-log/days/${day}/10:45");

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
