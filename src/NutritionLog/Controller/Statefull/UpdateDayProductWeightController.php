<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller\Statefull;


use App\NutritionLog\Command\UpdateDayProductWeightCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/users/{userId}/days/{day}/products/{productId}', methods: 'PATCH')]
final class UpdateDayProductWeightController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $day, string $productId, string $userId): JsonResponse
    {
        $bus->dispatch(
            new UpdateDayProductWeightCommand(
                day: $day,
                productId: $productId,
                weight: (float)$request->getPayload()->get('weight'),
                userId: $userId,
            )
        );

        return $this->json(null, Response::HTTP_OK);
    }
}
