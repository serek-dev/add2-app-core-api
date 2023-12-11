<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller\Statefull;


use App\NutritionLog\Command\RemoveDayMealDtoCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/users/{userId}/days/{date}/meals/{mealId}', methods: 'DELETE')]
final class RemoveDayMealController extends AbstractController
{
    public function __invoke(Request             $request,
                             string              $userId,
                             string              $date,
                             string              $mealId,
                             MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(
            new RemoveDayMealDtoCommand(
                day: $date,
                mealId: $mealId,
                userId: $userId,
            )
        );

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}
