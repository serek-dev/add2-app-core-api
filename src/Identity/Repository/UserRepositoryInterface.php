<?php

declare(strict_types=1);

namespace App\Identity\Repository;

use App\Identity\Entity\User;
use App\Shared\Exception\NotFoundException;

interface UserRepositoryInterface
{
    public function findByIdentifier(string $identifier): ?User;

    /**
     * @throws NotFoundException
     */
    public function updateJwt(string $identifier, string $jwt): void;
}