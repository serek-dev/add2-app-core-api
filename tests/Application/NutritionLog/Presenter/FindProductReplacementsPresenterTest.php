<?php

declare(strict_types=1);


namespace App\Tests\Application\NutritionLog\Presenter;


use App\NutritionLog\ViewQuery\Day\FindDayViewInterface;
use App\Tests\Application\NutritionLog\NutritionLogTestCase;
use Symfony\Component\HttpFoundation\Response;

/** @covers \App\NutritionLog\Presenter\FindProductReplacementsPresenter */
final class FindProductReplacementsPresenterTest extends NutritionLogTestCase
{
    public function testICanFindReplacementsForADayProduct(): void
    {
        $this->iAmAuthenticated();

        $day = '2021-01-03';

        $this->withPancakeMeal()
            ->withMealInNutritionLog($day, '10:45', parent::PANCAKE)
            ->withEgg()
            ->withProductInNutritionLog($day, '10:45', parent::EGG, 50);

        $dayProductId = $this->findDayProductId($day, parent::EGG);

        $response = $this->iCallGetApi("/api/nutrition-log/${day}/products/${dayProductId}/replacements");

        $this->assertCollectionFormat($response);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $body = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('metadata', $body);
        $metadataKeys = [
            'replacedProductId',
            'replacedOriginalProductId',
            'replacedProductName',
            'replacedProductWeight',
            'replacedProductKcal',
            'count',
        ];
        $this->assertEquals($metadataKeys, array_keys($body['metadata']));

        $collectionKeys = [
            'id',
            'name',
            'producerName',
            'weight',
        ];
        foreach ($body['collection'] as $item) {
            $this->assertEquals($collectionKeys, array_keys($item));
        }
    }

    private function findDayProductId(string $day, string $dayProductId): string
    {
        /** @var FindDayViewInterface $repo */
        $repo = self::getContainer()->get(FindDayViewInterface::class);

        $day = $repo->findDay($day);

        $product = null;

        foreach ($day->getProducts() as $dayProduct) {
            if ($dayProduct->productId === $dayProductId) {
                $product = $dayProduct;
                break;
            }
        }

        return $product->id;
    }
}
