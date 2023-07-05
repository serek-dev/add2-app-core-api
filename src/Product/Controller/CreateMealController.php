<?php

declare(strict_types=1);


namespace App\Product\Controller;


use App\Product\Command\CreateMealCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/meals', methods: 'POST')]
final class CreateMealController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus): JsonResponse
    {
        $bus->dispatch(
            new CreateMealCommand(
                name: $request->getPayload()->get('name'),
                products: $request->getPayload()->all('products'),
            )
        );

        return $this->json(null, Response::HTTP_CREATED);
    }
}
