<?php

declare(strict_types=1);


namespace App\Diary\Value;


use App\Diary\Exception\InvalidArgumentException;
use DateTimeInterface;
use Stringable;

final class ConsumptionTime implements Stringable
{
    public function __construct(private string|DateTimeInterface $value)
    {
        $this->value = is_string($this->value) ? $this->value : $this->value->format('H:i');

        [$h, $min] = explode(':', $this->value);
        $allowed = ['00', '15', '30', '45'];
        if (!in_array($min, $allowed)) {
            throw new InvalidArgumentException('Consumption time must be one of 15 min ranges');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
