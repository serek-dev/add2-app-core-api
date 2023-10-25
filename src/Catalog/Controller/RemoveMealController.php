<?php

declare(strict_types=1);

namespace App\Catalog\Controller;

use App\Catalog\Command\RemoveMealCommand;
use App\Catalog\Exception\NotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/catalog/meals/{id}', methods: 'DELETE')]
final class RemoveMealController extends AbstractController
{
    public function __invoke(string $id, MessageBusInterface $bus)
    {
        try {
            $command = new RemoveMealCommand($id);
            $bus->dispatch($command);
            return $this->json(null, Response::HTTP_ACCEPTED);
        } catch (HandlerFailedException $e) {
            if ($e->getPrevious() instanceof NotFoundException) {
                return $this->json(['message' => $e->getPrevious()->getMessage()], Response::HTTP_NOT_FOUND);
            }
            throw $e;
        }
    }
}