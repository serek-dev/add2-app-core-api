<?php

declare(strict_types=1);

namespace App\Metric\Factory;

use App\Metric\Dto\CreateMetricDtoInterface;
use App\Metric\Entity\Metric;
use App\Metric\Value\MetricType;
use App\Shared\Event\ProductAddedToNutritionLogInterface;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;

final readonly class MetricFactoryDirector
{
    /**
     * @param iterable|MetricFactoryInterface[] $factories
     */
    public function __construct(private iterable $factories = [])
    {
    }

    public function create(CreateMetricDtoInterface $dto): Metric
    {
        foreach ($this->factories as $f) {
            if ($f->supports($dto->getType())) {
                $new = $f->create(
                    $dto->getType(),
                    $dto->getValue(),
                    $dto->getDate() ?? new DateTimeImmutable(), null, null
                );
                return $new;
            }
        }

        throw new DomainException('Unsupported metric type');
    }

    public function createFromProductAddedToNutritionLog(ProductAddedToNutritionLogInterface $event): Metric
    {
        foreach ($this->factories as $f) {
            if ($f->supports('kcal')) {
                $new = $f->create(
                    'kcal',
                    $event->getKcal(),
                    $event->getDate(),
                    $event->getDayProductId(),
                    $event::NAME,
                );
                return $new;
            }
        }

        throw new DomainException('Unsupported metric type');
    }

    public function createByArguments(MetricType $type, float|string|int $value, DateTimeInterface $date, ?string $parentId, ?string $parentName): Metric
    {
        foreach ($this->factories as $f) {
            if ($f->supports('kcal')) {
                $new = $f->create(
                    $type->value,
                    $value,
                    $date,
                    $parentId ?? null,
                    $parentName ?? null,
                );
                return $new;
            }
        }

        throw new DomainException('Unsupported metric type');
    }
}