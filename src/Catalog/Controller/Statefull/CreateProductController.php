<?php

declare(strict_types=1);


namespace App\Catalog\Controller\Statefull;


use App\Catalog\Command\CreateProductCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/users/{userId}/products', methods: 'POST')]
final class CreateProductController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $userId): JsonResponse
    {
        $bus->dispatch(
            new CreateProductCommand(
                name: $request->getPayload()->get('name'),
                proteins: (float)$request->getPayload()->get('proteins'),
                fats: (float)$request->getPayload()->get('fats'),
                carbs: (float)$request->getPayload()->get('carbs'),
                kcal: (float)$request->getPayload()->get('kcal'),
                userId: $userId,
                producerName: $request->getPayload()->get('producerName') ?? null,
                id: $request->getPayload()->get('id'),
                unit: $request->getPayload()->get('unit') ?? null,
                weightPerUnit: (int)$request->getPayload()->get('weightPerUnit') ?? null,
            )
        );

        return $this->json(null, Response::HTTP_CREATED);
    }
}
