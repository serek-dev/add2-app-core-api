<?php

declare(strict_types=1);

namespace App\Catalog\Controller\Statefull;

use App\Catalog\Command\RemoveMealProductCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/users/{userId}/meals/{mealId}/products/{productId}', methods: 'DELETE')]
final class RemoveMealProductController extends AbstractController
{
    public function __invoke(string $userId, string $mealId, string $productId, MessageBusInterface $bus)
    {
        $command = new RemoveMealProductCommand($mealId, $productId, $userId);

        $bus->dispatch($command);

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}