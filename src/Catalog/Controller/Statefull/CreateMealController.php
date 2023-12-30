<?php

declare(strict_types=1);


namespace App\Catalog\Controller\Statefull;


use App\Catalog\Command\CreateMealCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use function uniqid;

#[AsController]
#[Route('/api/catalog/users/{userId}/meals', methods: 'POST')]
final class CreateMealController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $userId): JsonResponse
    {
        $bus->dispatch(
            new CreateMealCommand(
                userId: $userId,
                name: $request->getPayload()->get('name'),
                products: $request->getPayload()->get('products') ?? [],
                description: $request->getPayload()->get('description'),
                id: $id = uniqid('M-'),
            )
        );

        return $this->json(['item' => [
            'id' => $id,
        ]], Response::HTTP_CREATED);
    }
}
