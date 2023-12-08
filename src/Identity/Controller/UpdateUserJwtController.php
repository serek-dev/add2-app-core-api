<?php

declare(strict_types=1);

namespace App\Identity\Controller;

use App\Identity\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/identity/users/{identifier}/jwt', methods: ['PATCH'])]
final class UpdateUserJwtController extends AbstractController
{
    public function __invoke(Request $request, string $identifier, UserRepositoryInterface $repository): JsonResponse
    {
        $repository->updateJwt($identifier, $request->getPayload()->get('jwt'));

        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}