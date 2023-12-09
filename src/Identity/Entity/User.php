<?php

declare(strict_types=1);

namespace App\Identity\Entity;

use Column as ColumnAlias;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
final class User
{
    #[Column]
    private ?string $jwt = null;

    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private string $id,
        #[Column]
        private string $identifier,
        #[Column]
        private string $hashedPassword,
        ?string        $jwt)
    {
        $this->jwt = $jwt;
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

    public function setJwt(?string $jwt): void
    {
        $this->jwt = $jwt;
    }

    public function getJwt(): ?string
    {
        return $this->jwt;
    }
}