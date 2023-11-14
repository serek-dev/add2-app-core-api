<?php

declare(strict_types=1);

namespace Metric\Factory;

use App\Metric\Factory\KcalMetricFactory;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Metric\Factory\KcalMetricFactory */
final class KcalMetricFactoryTest extends TestCase
{
    public function testSupports(): void
    {
        $factory = new KcalMetricFactory();

        self::assertTrue($factory->supports('kcal'));
        self::assertFalse($factory->supports('foo'));
    }

    public function testCreate(): void
    {
        $factory = new KcalMetricFactory();

        $metric = $factory->create('kcal', 100.0, new DateTimeImmutable());

        self::assertSame('kcal', $metric->getType());
        self::assertSame(100.0, $metric->getValue());
    }

    public function testCreateWithInvalidValue(): void
    {
        $factory = new KcalMetricFactory();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Invalid kcal value');

        $factory->create('kcal', 5001, new DateTimeImmutable());
    }
}
