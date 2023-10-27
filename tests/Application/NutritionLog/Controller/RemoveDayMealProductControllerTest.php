<?php

declare(strict_types=1);


namespace App\Tests\Application\NutritionLog\Controller;


use App\Shared\DataFixtures\MealFixtures;
use App\Tests\Application\NutritionLog\NutritionLogTestCase;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\NutritionLog\Controller\RemoveDayMealProductController */
final class RemoveDayMealProductControllerTest extends NutritionLogTestCase
{
    public function testICanAddAMealToNonExistingDay(): void
    {
        $this->markTestSkipped('Not testable yet');

        $date = (new DateTimeImmutable())->format('Y-m-d');
        $productId = MealFixtures::MEAL_1_MEAL_PRODUCT_1;

        $response = $this->iCallDeleteApi("/api/nutrition-log/$date/products/$productId");

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
