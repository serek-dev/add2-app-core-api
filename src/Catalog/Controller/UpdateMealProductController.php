<?php

declare(strict_types=1);


namespace App\Catalog\Controller;


use App\Catalog\Command\UpdateMealProductWeightWeightCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/meals/{mealId}/products/{productId}', methods: 'PATCH')]
final class UpdateMealProductController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $mealId, string $productId): JsonResponse
    {
        $bus->dispatch(
            new UpdateMealProductWeightWeightCommand(
                mealId: $mealId,
                productId: $productId,
                weight: (float)$request->getPayload()->get('weight')
            )
        );

        return $this->json(null, Response::HTTP_OK);
    }
}
