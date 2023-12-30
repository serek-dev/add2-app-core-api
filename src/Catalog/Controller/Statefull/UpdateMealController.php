<?php

declare(strict_types=1);


namespace App\Catalog\Controller\Statefull;


use App\Catalog\Command\UpdateMealCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/users/{userId}/meals/{id}', methods: 'PUT')]
final class UpdateMealController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $userId, string $id): JsonResponse
    {
        $bus->dispatch(
            new UpdateMealCommand(
                userId: $userId,
                name: $request->getPayload()->get('name'),
                description: $request->getPayload()->get('description'),
                id: $id,
            )
        );

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}
