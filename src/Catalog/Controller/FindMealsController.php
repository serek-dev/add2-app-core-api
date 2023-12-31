<?php

declare(strict_types=1);


namespace App\Catalog\Controller;


use App\Catalog\ViewQuery\Meal\FindMealViewsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/meals', methods: 'GET')]
final class FindMealsController extends AbstractController
{
    public function __invoke(Request $request, FindMealViewsInterface $query): JsonResponse
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
