<?php

declare(strict_types=1);


namespace App\Catalog\Controller;


use App\Catalog\ViewQuery\Product\FindProductViewsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/products', methods: 'GET')]
final class FindProductsController extends AbstractController
{
    public function __invoke(Request $request, FindProductViewsInterface $query): JsonResponse
    {
        $results = $query->findAll($request->get('name'));

        return $this->json([
            'collection' => $results,
            'metadata' => [
                'count' => count($results),
            ]
        ], Response::HTTP_OK);
    }
}
