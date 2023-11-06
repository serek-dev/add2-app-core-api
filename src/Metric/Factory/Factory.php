<?php

declare(strict_types=1);

namespace App\Metric\Factory;

use App\Metric\Dto\CreateMetricDtoInterface;
use App\Metric\Entity\Metric;
use DateTimeImmutable;
use DomainException;

final class Factory
{
    /**
     * @param iterable|MetricFactoryInterface[] $factories
     */
    public function __construct(private readonly iterable $factories = [])
    {
    }

    public function create(CreateMetricDtoInterface $dto): Metric
    {
        foreach ($this->factories as $f) {
            if ($f->supports($dto->getType())) {
                $new = $f->create(
                    $dto->getType(),
                    $dto->getValue(),
                    $dto->getDate() ?? new DateTimeImmutable()
                );
                return $new;
            }
        }

        throw new DomainException('Unsupported metric type');
    }
}