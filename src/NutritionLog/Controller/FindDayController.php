<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller;


use App\NutritionLog\ViewQuery\Day\FindDayInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/{dayId}', methods: 'GET')]
final class FindDayController extends AbstractController
{
    public function __invoke(Request $request, FindDayInterface $query): JsonResponse
    {
        return $this->json([
            'item' => $query->findDay($request->get('dayId')),
        ]);
    }
}
