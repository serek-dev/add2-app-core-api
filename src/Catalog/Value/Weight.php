<?php

declare(strict_types=1);


namespace App\Catalog\Value;


use InvalidArgumentException;

final class Weight
{
    public function __construct(private readonly float $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Value should not be less than 0');
        }
    }

    public function getRaw(): float
    {
        return $this->value;
    }
}
