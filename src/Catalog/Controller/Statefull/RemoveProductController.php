<?php

declare(strict_types=1);

namespace App\Catalog\Controller\Statefull;

use App\Catalog\Command\RemoveProductCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/users/{userId}/products/{id}', methods: 'DELETE')]
final class RemoveProductController extends AbstractController
{
    public function __invoke(string $userId, string $id, MessageBusInterface $bus)
    {
        $command = new RemoveProductCommand($id, $userId);

        $bus->dispatch($command);

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}