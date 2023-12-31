<?php

declare(strict_types=1);

namespace App\ActivityLog\Entity;

use App\ActivityLog\Value\ActivityType;
use App\Shared\Entity\AggregateRoot;
use DateTimeInterface;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
final class Activity implements AggregateRoot
{
    public function __construct(
        #[Id]
        #[GeneratedValue(strategy: "NONE")]
        #[Column]
        private string $id,
        #[Column(length: 50, enumType: 'string')]
        private ActivityType $type,
        #[Column(length: 150)]
        private string $name,
        #[Column(type: 'datetime')]
        private DateTimeInterface $date,
        #[Column]
        private string $userId,
        #[Column]
        private int $duration = 0,
        #[Column]
        private ?string $details = null,
        #[Column]
        private ?string $url = null,
        #[Column(nullable: true)]
        private ?float $distance = null,
        #[Column(nullable: true)]
        private ?int $elevation = null,
        #[Column(nullable: true)]
        private ?int $avgHr = 0,
        #[Column]
        private int $kcal = 0,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): ActivityType
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getElevation(): ?int
    {
        return $this->elevation;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function getAvgHr(): ?int
    {
        return $this->avgHr;
    }

    public function getKcal(): int
    {
        return $this->kcal;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function pullEvents(): array
    {
        return [];
    }
}