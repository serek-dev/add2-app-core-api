<?php

declare(strict_types=1);

namespace App\Catalog\Controller\Statefull;

use App\Catalog\Command\RemoveMealCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/users/{userId}/meals/{id}', methods: 'DELETE')]
final class RemoveMealController extends AbstractController
{
    public function __invoke(string $userId, string $id, MessageBusInterface $bus): JsonResponse
    {
        $command = new RemoveMealCommand($id, $userId);

        $bus->dispatch($command);

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}