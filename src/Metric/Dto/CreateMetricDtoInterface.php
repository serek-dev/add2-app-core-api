<?php

declare(strict_types=1);

namespace App\Metric\Dto;

use DateTimeInterface;

interface CreateMetricDtoInterface
{
    public function getType(): string;

    public function getValue(): float|int|string;

    public function getDate(): ?DateTimeInterface;

    public function getUserId(): string;
}