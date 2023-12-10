<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller\Statefull;


use App\NutritionLog\Command\AddDayProductCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/users/{userId}/days/{dayId}/products', methods: ['POST'])]
final class AddDayProductController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $userId, string $dayId): JsonResponse
    {
        $bus->dispatch(
            new AddDayProductCommand(
                date: $dayId,
                consumptionTime: $request->getPayload()->get('consumptionTime'),
                productId: $request->getPayload()->get('productId'),
                productWeight: (float)$request->getPayload()->get('productWeight'),
                userId: $userId,
            )
        );

        return $this->json(null, Response::HTTP_CREATED);
    }
}
