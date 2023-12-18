<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller\Statefull;


use App\NutritionLog\Command\ReplaceMealProductCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/users/{userId}/days/{day}/meals/{mealId}/products/{productId}/replace', methods: 'PATCH')]
final class ReplaceMealProductController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $day, string $userId, string $mealId, string $productId): JsonResponse
    {
        $bus->dispatch(
            new ReplaceMealProductCommand(
                day: $day,
                mealId: $mealId,
                productId: $productId,
                newProductId: (string)$request->getPayload()->get('newProductId'),
                userId: $userId,
            )
        );

        return $this->json(null, Response::HTTP_OK);
    }
}
