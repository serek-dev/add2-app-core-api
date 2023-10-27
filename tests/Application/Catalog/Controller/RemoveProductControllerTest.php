<?php

declare(strict_types=1);

namespace App\Tests\Application\Catalog\Controller;


use App\Shared\DataFixtures\ProductFixtures;
use App\Tests\Application\Catalog\CatalogTestCase;
use Symfony\Component\HttpFoundation\Response;

final class RemoveProductControllerTest extends CatalogTestCase
{
    public function testICanSeeNotFound(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallDeleteApi('/api/catalog/products/non-existing');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testICanRemove(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallDeleteApi('/api/catalog/products/' . ProductFixtures::PRODUCT_1);

        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
    }
}
