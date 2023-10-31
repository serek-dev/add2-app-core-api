<?php

declare(strict_types=1);

namespace App\Catalog\Value;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use DomainException;

#[Embeddable]
class Portion
{
    public function __construct(
        #[Column(length: 30, nullable: true)]
        private readonly ?string $unit = null,
        #[Column(nullable: true)]
        private readonly ?int    $weightPerUnit = null)
    {
        if ($this->unit && !$this->weightPerUnit || !$this->unit && $this->weightPerUnit) {
            throw new DomainException('Both unit and weightPerUnit must be set or null');
        }
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getWeightPerUnit(): ?int
    {
        return $this->weightPerUnit;
    }
}