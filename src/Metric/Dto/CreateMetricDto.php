<?php

declare(strict_types=1);

namespace App\Metric\Dto;

use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final readonly class CreateMetricDto implements CreateMetricDtoInterface
{
    public function __construct(
        #[NotBlank]
        #[Choice(choices: ['weight', 'hunger', 'kcal'])]
        public string|null $type,
        #[NotBlank]
        #[Type(type: ['float', 'int', 'string'])]
        #[Length(max: 75)]
        public string|int|float|null $value,
        #[DateTime]
        public string|null           $date,
    )
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): float|int|string
    {
        return $this->value;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date ? new DateTimeImmutable($this->date) : null;
    }
}