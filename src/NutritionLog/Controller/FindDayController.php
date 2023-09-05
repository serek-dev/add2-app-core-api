<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller;


use App\NutritionLog\ViewQuery\Day\FindDayViewInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/{date}', methods: 'GET')]
final class FindDayController extends AbstractController
{
    public function __invoke(Request $request, FindDayViewInterface $presenter): JsonResponse
    {
        return $this->json([
            'item' => $presenter->findDay($request->get('date')),
        ]);
    }
}
