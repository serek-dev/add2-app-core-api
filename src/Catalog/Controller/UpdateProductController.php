<?php

declare(strict_types=1);


namespace App\Catalog\Controller;


use App\Catalog\Command\UpdateProductCommand;
use App\Catalog\Exception\NotFoundException;
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
#[Route('/api/catalog/products/{id}', methods: 'PUT')]
final class UpdateProductController extends AbstractController
{
    public function __invoke(Request $request, string $id, MessageBusInterface $bus): JsonResponse
    {
        try {
            $bus->dispatch(
                new UpdateProductCommand(
                    id: $id,
                    name: $request->getPayload()->get('name'),
                    proteins: (float)$request->getPayload()->get('proteins'),
                    fats: (float)$request->getPayload()->get('fats'),
                    carbs: (float)$request->getPayload()->get('carbs'),
                    kcal: (float)$request->getPayload()->get('kcal'),
                    producerName: $request->getPayload()->get('producerName') ?? null,
                    unit: $request->getPayload()->get('unit') ?? null,
                    weightPerUnit: (int)$request->getPayload()->get('weightPerUnit') ?? null,
                )
            );
        } catch (HandlerFailedException $e) {
            if ($e->getPrevious() instanceof NotFoundException) {
                throw $this->createNotFoundException($e->getPrevious()->getMessage());
            }

            throw new BadRequestException($e->getMessage());
        }

        return $this->json(null, Response::HTTP_OK);
    }
}
