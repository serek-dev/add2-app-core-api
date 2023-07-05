<?php

declare(strict_types=1);


namespace App\Product\Controller;


use App\Product\ViewQuery\Product\FindProductsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/products', methods: 'GET')]
final class FindProductsController extends AbstractController
{
    public function __invoke(Request $request, FindProductsInterface $query): JsonResponse
    {
        $results = $query->findAll($request->get('name'));

        return $this->json([
            'collection' => $results,
            'metadata' => [
                'count' => count($results),
            ]
        ], Response::HTTP_CREATED);
    }
}
