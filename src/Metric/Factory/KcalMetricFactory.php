<?php

declare(strict_types=1);

namespace App\Metric\Factory;

use App\Metric\Entity\Metric;
use DateTimeInterface;
use DomainException;

final class KcalMetricFactory implements MetricFactoryInterface
{
    public function supports(string $type): bool
    {
        return $type === 'kcal';
    }

    public function create(string $type, float|string|int $value, DateTimeInterface $date, string $userId, ?string $parentId, ?string $parentName): Metric
    {
        if ($value < 0 || $value > 5000) {
            throw new DomainException('Invalid kcal value');
        }

        return new Metric($type, (float)$value, $date, $userId, $parentId, $parentName);
    }
}