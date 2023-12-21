<?php

declare(strict_types=1);

namespace App\Identity\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class User
{
    #[Column(length: 1000, nullable: true)]
    private ?string $jwt = null;

    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private string $id,
        #[Column]
        private string $identifier,
        #[Column(length: 50)]
        private string $firstName,
        #[Column(length: 50)]
        private string $lastName,
        #[Column]
        private string $email,
        #[Column(nullable: true)]
        private string $hashedPassword,
        ?string        $jwt = null)
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}