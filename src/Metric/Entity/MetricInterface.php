<?php

declare(strict_types=1);

namespace App\Metric\Entity;

use DateTimeInterface;

interface MetricInterface
{
    public function getType(): string;

    public function getValue(): string|int|float;

    public static function createFrom(string $type, string|int|float $value, DateTimeInterface $time): static;
}