<?php

declare(strict_types=1);


namespace App\NutritionLog\Value;


use InvalidArgumentException;
use Stringable;

final class Weight implements Stringable
{
    public function __construct(private readonly float $value = 0.0)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Value should not be less than 0');
        }
    }

    public function getRaw(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
