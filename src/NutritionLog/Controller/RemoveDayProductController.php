<?php

declare(strict_types=1);


namespace App\NutritionLog\Controller;


use App\NutritionLog\Command\RemoveDayProductDtoCommand;
use App\NutritionLog\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/nutrition-log/days/{date}/products/{productId}', methods: 'DELETE')]
final class RemoveDayProductController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $date, string $productId): JsonResponse
    {
        try {
            $bus->dispatch(
                new RemoveDayProductDtoCommand(
                    date: $date,
                    productId: $productId,
                )
            );
        } catch (HandlerFailedException $e) {
            if ($e->getPrevious() instanceof NotFoundException) {
                return $this->json(['message' => $e->getPrevious()->getMessage()], Response::HTTP_NOT_FOUND);
            }

            throw new BadRequestException($e->getMessage());
        }

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}
