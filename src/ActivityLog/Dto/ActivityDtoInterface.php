<?php

declare(strict_types=1);

namespace App\ActivityLog\Dto;

use App\ActivityLog\Value\ActivityType;
use DateTimeInterface;

interface ActivityDtoInterface
{
    public function getType(): ActivityType;

    public function getName(): string;

    public function getUserId(): string;

    public function getDistance(): ?float;

    public function getDuration(): int;

    public function getElevation(): ?int;

    public function getDate(): ?DateTimeInterface;

    public function getAvgHr(): ?int;

    public function getKcal(): int;

    public function getDetails(): ?string;

    public function getUrl(): ?string;
}