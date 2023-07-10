<?php

declare(strict_types=1);


namespace App\Product\Controller;


use App\Product\Exception\NotFoundException;
use App\Product\ViewQuery\Meal\GetOneMealInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/meals/{id}', methods: 'GET')]
final class GetMealController extends AbstractController
{
    public function __invoke(Request $request, GetOneMealInterface $query): JsonResponse
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
