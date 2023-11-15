<?php

declare(strict_types=1);

namespace App\Metric\Repository;

use App\Metric\Entity\Metric;

interface CreateMetricInterface
{
    public function store(Metric ...$metric): void;

    public function removeByParentIdAndName(string $parentId, string $parentName): void;
}