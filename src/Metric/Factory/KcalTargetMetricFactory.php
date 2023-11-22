<?php

declare(strict_types=1);

namespace App\Metric\Factory;

use App\Metric\Entity\Metric;
use App\Metric\Value\MetricType;
use DateTimeInterface;
use DomainException;

final class KcalTargetMetricFactory implements MetricFactoryInterface
{
    public function supports(string $type): bool
    {
        return $type === MetricType::KCAL_TARGET->value;
    }

    public function create(string $type, float|int|string $value, DateTimeInterface $date, ?string $parentId, ?string $parentName): Metric
    {
        if ($value < 0 || $value > 5000) {
            throw new DomainException('Invalid kcal value');
        }

        return new Metric($type, (float)$value, $date, $parentId, $parentName);
    }
}