<?php

declare(strict_types=1);

namespace App\Metric\Repository;

use App\Metric\Entity\Metric;
use App\Metric\Value\MetricType;

interface CreateMetricInterface
{
    public function store(Metric ...$metric): void;

    public function updateByParentIdAndType(string $parentId, MetricType $type, float $value): void;

    public function removeByParentIdAndName(string $parentId, string $parentName): void;
}