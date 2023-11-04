<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller;


use App\NutritionLog\Command\AddDayProductCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/days/{dayId}/products', methods: ['POST'])]
final class AddDayProductController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(
            new AddDayProductCommand(
                date: $request->get('dayId'),
                consumptionTime: $request->getPayload()->get('consumptionTime'),
                productId: $request->getPayload()->get('productId'),
                productWeight: (float)$request->getPayload()->get('productWeight'),
            )
        );

        return $this->json(null, Response::HTTP_CREATED);
    }
}
