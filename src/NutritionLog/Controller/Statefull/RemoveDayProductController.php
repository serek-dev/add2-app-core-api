<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller\Statefull;


use App\NutritionLog\Command\RemoveDayProductDtoCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/users/{userId}/days/{date}/products/{productId}', methods: 'DELETE')]
final class RemoveDayProductController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $userId, string $date, string $productId): JsonResponse
    {
        $bus->dispatch(
            new RemoveDayProductDtoCommand(
                date: $date,
                productId: $productId,
                userId: $userId,
            )
        );

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}
