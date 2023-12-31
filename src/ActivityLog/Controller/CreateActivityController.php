<?php

declare(strict_types=1);

namespace App\ActivityLog\Controller;

use App\ActivityLog\Command\CreateActivityCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/activity-log/users/{userId}/activities', methods: 'POST')]
final class CreateActivityController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $bus, string $userId): JsonResponse
    {
        $bus->dispatch(
            new CreateActivityCommand(
                type: $request->getPayload()->get('type'),
                userId: $userId,
                name: $request->getPayload()->get('name'),
                duration: $request->getPayload()->get('duration'),
                kcal: $request->getPayload()->get('kcal'),
                date: $request->getPayload()->get('date'),
                details: $request->getPayload()->get('details'),
                url: $request->getPayload()->get('url'),
                distance: $request->getPayload()->get('distance'),
                elevation: $request->getPayload()->get('elevation'),
                avgHr: $request->getPayload()->get('avgHr'),
            )
        );

        return $this->json(null, Response::HTTP_CREATED);
    }
}