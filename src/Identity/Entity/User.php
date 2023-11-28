<?php

declare(strict_types=1);

namespace App\Identity\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
final class User
{
    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private string $id,
        #[Column]
        private string $identifier,
        #[Column]
        private string $hashedPassword)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}