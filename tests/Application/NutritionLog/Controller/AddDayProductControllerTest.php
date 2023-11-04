<?php

declare(strict_types=1);


namespace App\Tests\Application\NutritionLog\Controller;


use App\Tests\Application\NutritionLog\NutritionLogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\NutritionLog\Controller\AddDayProductController */
final class AddDayProductControllerTest extends NutritionLogTestCase
{
    public function testICanAddAProductToNonExistingDay(): void
    {
        $this->withMilk();
        $this->iAmAuthenticated();
        $response = $this->iCallPostApi('/api/nutrition-log/days/2020-01-01/products', [
            'consumptionTime' => '10:15',
            'productId' => self::MILK,
            'productWeight' => 50.0,
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testICanAddAProductToExistingDay(): void
    {
        $this->withMilk();
        $this->iAmAuthenticated();
        $response = $this->iCallPostApi('/api/nutrition-log/days/2020-01-01/products', [
            'consumptionTime' => '10:15',
            'productId' => self::MILK,
            'productWeight' => 50.0,
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}
