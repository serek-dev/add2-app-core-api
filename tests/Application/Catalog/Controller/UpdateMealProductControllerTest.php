<?php

declare(strict_types=1);

namespace App\Tests\Application\Catalog\Controller;

use App\Shared\DataFixtures\MealFixtures;
use App\Shared\DataFixtures\ProductFixtures;
use App\Tests\Application\Catalog\CatalogTestCase;
use Symfony\Component\HttpFoundation\Response;
use function sprintf;

/** @covers \App\Catalog\Controller\Statefull\AddMealProductController */
final class UpdateMealProductControllerTest extends CatalogTestCase
{
    public function testICanAddProductToExistingMeal(): void
    {
        $this->markTestSkipped('Hard to test');

        $this->iAmAuthenticated();

        $response = $this->iCallPostApi(sprintf('/api/catalog/meals/%s/products/%s', MealFixtures::MEAL_1), [
            'productId' => ProductFixtures::PRODUCT_1,
            'weight' => 50,
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}