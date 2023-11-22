<?php

declare(strict_types=1);

namespace App\Metric\Dto;

use App\Metric\Value\AggregationType;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints\DateTime;

final class FindMetricDto
{
    public function __construct(
        public array|null  $types,
        #[DateTime]
        public string|null $from,
        #[DateTime]
        public string|null $to,
        public string|null $aggregation = null,
    )
    {
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function getFrom(): DateTimeInterface
    {
        return new DateTimeImmutable($this->from);
    }

    public function getTo(): DateTimeInterface
    {
        return new DateTimeImmutable($this->to);
    }

    public function getAggregation(): ?AggregationType
    {
        return $this->aggregation ? AggregationType::from($this->aggregation) : null;
    }
}