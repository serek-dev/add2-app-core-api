<?php

declare(strict_types=1);


namespace App\Catalog\Controller;


use App\Catalog\Exception\NotFoundException;
use App\Catalog\ViewQuery\Meal\GetOneMealViewInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/meals/{id}', methods: 'GET')]
final class GetMealController extends AbstractController
{
    public function __invoke(Request $request, GetOneMealViewInterface $query): JsonResponse
    {
        try {
            return $this->json(
                ['item' => $query->getOne($request->get('id'))],
            );
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException();
        }
    }
}
