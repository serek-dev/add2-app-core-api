<?php

declare(strict_types=1);


namespace App\Catalog\Controller\Statefull;


use App\Catalog\ViewQuery\Product\FindProductViewsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/users/{userId}/products/{id}', methods: 'GET')]
final class GetProductController extends AbstractController
{
    public function __invoke(Request $request, FindProductViewsInterface $query, string $userId, string $id): JsonResponse
    {
        $results = $query->getOneByUser($id, $userId);

        return $this->json(['item' => $results]);
    }
}
