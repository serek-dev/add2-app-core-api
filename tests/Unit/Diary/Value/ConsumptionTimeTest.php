<?php

namespace App\Tests\Unit\Diary\Value;

use App\Diary\Exception\InvalidArgumentException;
use App\Diary\Value\ConsumptionTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Stringable;

/** @covers \App\Diary\Value\ConsumptionTime */
final class ConsumptionTimeTest extends TestCase
{
    /** @dataProvider providerForConstructor */
    public function testConstructor(string $value): void
    {
        $sut = new ConsumptionTime($value);
        $this->assertInstanceOf(Stringable::class, $sut);
    }

    /** @dataProvider providerForConstructorFailsOnNon15minutesInterval */
    public function testConstructorFailsOnNon15minutesInterval(string $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $sut = new ConsumptionTime($value);
    }

    public function providerForConstructorFailsOnNon15minutesInterval(): array
    {
        return [
            ['10:31'],
            ['10:32'],
            ['11:46'],
        ];
    }

    public function providerForConstructor(): array
    {
        return [
            ['10:00'],
            ['10:15'],
            ['11:30'],
            ['11:45'],
        ];
    }

    public function testConstructorAsString(): void
    {
        $sut = new ConsumptionTime('10:30');
        $this->assertSame('10:30', (string)$sut);
        $this->assertSame('10:30', $sut->getValue());
    }

    public function testConstructorAsDate(): void
    {
        $sut = new ConsumptionTime(new DateTimeImmutable('2020-01-01 10:30'));
        $this->assertSame('10:30', (string)$sut);
        $this->assertSame('10:30', $sut->getValue());
    }
}
