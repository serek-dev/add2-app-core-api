<?php

declare(strict_types=1);

namespace App\ActivityLog\Command;

use App\ActivityLog\Dto\ActivityDtoInterface;
use App\ActivityLog\Value\ActivityType;
use DateTimeImmutable;
use DateTimeInterface;

final class CreateActivityCommand implements ActivityDtoInterface
{
    public function __construct(
        private string  $type,
        private string  $userId,
        private string  $name,
        private int     $duration,
        private int     $kcal,
        private ?string $date = null,
        private ?string $details = null,
        private ?string $url = null,
        private ?float  $distance = null,
        private ?int    $elevation = null,
        private ?int    $avgHr = null,
    )
    {
    }

    public function getType(): ActivityType
    {
        return ActivityType::from($this->type);
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

    public function getDate(): ?DateTimeInterface
    {
        if (!$this->date) {
            return null;
        }
        return new DateTimeImmutable($this->date);
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

    public function getUserId(): string
    {
        return $this->userId;
    }
}