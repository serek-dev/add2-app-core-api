<?php

declare(strict_types=1);

namespace App\Tests\Application\Catalog\Controller;


use App\Tests\Application\Catalog\CatalogTestCase;
use Symfony\Component\HttpFoundation\Response;

final class RemoveMealControllerTest extends CatalogTestCase
{
    public function testICanSeeNotFound(): void
    {
        $this->iAmAuthenticated();

        $response = $this->iCallDeleteApi('/api/catalog/meals/non-existing');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testICanRemove(): void
    {
        $this->iAmAuthenticated();

        $this->withPancakeMeal();

        $response = $this->iCallDeleteApi('/api/catalog/meals/' . self::PANCAKE);

        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
    }
}
