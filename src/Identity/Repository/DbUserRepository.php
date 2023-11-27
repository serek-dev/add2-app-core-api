<?php

declare(strict_types=1);

namespace App\Identity\Repository;

use App\Identity\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final class DbUserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function findByIdentifier(string $identifier): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($identifier);
    }
}