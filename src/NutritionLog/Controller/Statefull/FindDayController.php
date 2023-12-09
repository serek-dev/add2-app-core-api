<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller\Statefull;


use App\NutritionLog\Presenter\FindDayApiPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/users/{userId}/days/{date}', methods: 'GET')]
final class FindDayController extends AbstractController
{
    public function __invoke(Request $request, FindDayApiPresenter $presenter, string $userId, string $date): JsonResponse
    {
        return $this->json($presenter->render($date, $userId));
    }
}
