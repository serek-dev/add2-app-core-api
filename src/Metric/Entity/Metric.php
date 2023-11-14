<?php

declare(strict_types=1);

namespace App\Metric\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use InvalidArgumentException;
use JsonSerializable;

#[Entity('metrics_metric')]
class Metric implements JsonSerializable
{
    #[Column(type: 'integer')]
    #[GeneratedValue]
    #[Id]
    private ?int $id;

    public function __construct(
        #[Column(length: 25)]
        private readonly string            $type,
        #[Column(type: 'string', length: 75)]
        private readonly string|int|float  $value,
        #[Column(type: 'datetime_immutable')]
        private readonly DateTimeInterface $time,
        #[Column(length: 75, nullable: true)]
        private readonly ?string           $parentId = null,
        #[Column(length: 75, nullable: true)]
        private readonly ?string           $parentName = null,
    )
    {
        if ($this->parentId === null && $this->parentName !== null) {
            throw new InvalidArgumentException('Parent name cannot be set without parent id');
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): float|int|string
    {
        return $this->value;
    }

    public function getTime(): DateTimeInterface
    {
        return $this->time;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'value' => $this->value,
            'time' => $this->time->format(DATE_ATOM),
        ];
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function getParentName(): ?string
    {
        return $this->parentName;
    }
}