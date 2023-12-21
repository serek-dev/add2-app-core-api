<?php

declare(strict_types=1);

namespace App\Identity\Controller;

use App\Identity\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/identity/users/{identifier}')]
final class GetUserByIdentifierController extends AbstractController
{
    public function __invoke(string $identifier, UserRepositoryInterface $repository): JsonResponse
    {
        $user = $repository->findByIdentifier($identifier);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        return $this->json([
            'item' => [
                'id' => $user->getId(),
                'identifier' => $user->getIdentifier(),
                'displayName' => $user->getFirstName() . ' ' . $user->getLastName(),
                'hashedPassword' => $user->getHashedPassword(),
                'jwt' => $user->getJwt(),
            ],
        ]);
    }
}