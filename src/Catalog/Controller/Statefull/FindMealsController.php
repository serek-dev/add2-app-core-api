<?php

declare(strict_types=1);


namespace App\Catalog\Controller\Statefull;


use App\Catalog\ViewQuery\Meal\FindMealViewsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/users/{userId}/meals', methods: 'GET')]
final class FindMealsController extends AbstractController
{
    public function __invoke(Request $request, string $userId, FindMealViewsInterface $query, #[MapQueryParameter] ?string $name = null): JsonResponse
    {
        $results = $query->findAll($userId, $name);

        return $this->json([
            'collection' => $results,
            'metadata' => [
                'count' => count($results),
            ]
        ], Response::HTTP_OK);
    }
}
