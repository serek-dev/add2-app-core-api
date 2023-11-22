<?php

declare(strict_types=1);

namespace Metric\Factory;

use App\Metric\Factory\KcalTargetMetricFactory;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Metric\Factory\KcalTargetMetricFactory */
final class KcalTargetMetricFactoryTest extends TestCase
{
    public function testSupports(): void
    {
        $factory = new KcalTargetMetricFactory();

        self::assertTrue($factory->supports('kcalTarget'));
        self::assertFalse($factory->supports('foo'));
    }

    public function testCreate(): void
    {
        $factory = new KcalTargetMetricFactory();

        $metric = $factory->create('kcalTarget', 100.0, new DateTimeImmutable(), 'id', 'name');

        self::assertSame('kcalTarget', $metric->getType());
        self::assertSame(100.0, $metric->getValue());
        self::assertSame('id', $metric->getParentId());
        self::assertSame('name', $metric->getParentName());
    }

    public function testCreateWithInvalidValue(): void
    {
        $factory = new KcalTargetMetricFactory();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Invalid kcal value');

        $factory->create('kcalTarget', 5001, new DateTimeImmutable(), null, null);
    }
}
