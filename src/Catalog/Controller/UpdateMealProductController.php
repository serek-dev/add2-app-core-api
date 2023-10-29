<?php

declare(strict_types=1);


namespace App\Catalog\Controller;


use App\Catalog\Command\UpdateMealProductWeightWeightCommand;
use App\Catalog\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/meals/{mealId}/products/{productId}', methods: 'PATCH')]
final class UpdateMealProductController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $mealId, string $productId): JsonResponse
    {
        try {
            $bus->dispatch(
                new UpdateMealProductWeightWeightCommand(
                    mealId: $mealId,
                    productId: $productId,
                    weight: (float)$request->getPayload()->get('weight')
                )
            );
        } catch (HandlerFailedException $e) {
            if ($e->getPrevious() instanceof NotFoundException) {
                return $this->json(['message' => $e->getPrevious()->getMessage()], Response::HTTP_NOT_FOUND);
            }

            throw $this->createNotFoundException($e->getMessage());
        }


        return $this->json(null, Response::HTTP_OK);
    }
}
