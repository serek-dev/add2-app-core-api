<?php

declare(strict_types=1);

namespace App\Tests\Application\Catalog\Controller;

use App\Catalog\Entity\Meal;
use App\Tests\Application\Catalog\CatalogTestCase;
use Symfony\Component\HttpFoundation\Response;
use function sprintf;

/** @covers \App\Catalog\Controller\AddMealProductController */
final class AddMealProductControllerTest extends CatalogTestCase
{
    public function testICanAddProductToExistingMeal(): void
    {
        $this->markTestSkipped('This test is not ready yet.');
        /*
         * I am authenticated
         * When I try to create a new product that does exist
         * Then I should see created status code
         */
        $this->iAmAuthenticated();

        $this->withPancakeMeal();
        $this->withWheyProtein();

        $response = $this->iCallPostApi(sprintf('/api/catalog/meals/%s/products', self::PANCAKE), [
            'productId' => self::WHEY_PROTEIN,
            'weight' => 50,
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $this->withNoPancakeMeal();
    }

    private function withNoPancakeMeal(): void
    {
        $this->em->remove(
            $entity = $this->em->getRepository(Meal::class)->find(self::PANCAKE)
        );
        $this->em->flush();
    }
}