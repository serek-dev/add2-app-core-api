<?php

declare(strict_types=1);


namespace App\Catalog\Controller;


use App\Catalog\Command\CreateMealCommand;
use App\Catalog\Exception\DuplicateException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use function uniqid;

#[AsController]
#[Route('/api/catalog/meals', methods: 'POST')]
final class CreateMealController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $id = $request->getPayload()->get('id') ?? uniqid('M-');

        try {
            $bus->dispatch(
                new CreateMealCommand(
                    name: $request->getPayload()->get('name'),
                    products: $request->getPayload()->all('products'),
                    id: $id,
                )
            );
        } catch (HandlerFailedException $e) {
            if ($e->getPrevious() instanceof DuplicateException) {
                return $this->json(['message' => $e->getPrevious()->getMessage()], Response::HTTP_CONFLICT);
            }

            throw new BadRequestException($e->getMessage());
        }


        return $this->json([
            'item' => ['id' => $id],
        ], Response::HTTP_CREATED);
    }
}
