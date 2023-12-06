<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller;


use App\NutritionLog\Command\RemoveDayProductsByConsumptionTimeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/days/{date}/{consumptionTime}', methods: 'DELETE')]
final class RemoveDayProductsByConsumptionTimeController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(
            new RemoveDayProductsByConsumptionTimeCommand(
                date: $request->get('date'),
                consumptionTime: $request->get('consumptionTime'),
            )
        );

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}
