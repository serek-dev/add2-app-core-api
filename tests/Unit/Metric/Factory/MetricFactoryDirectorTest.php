<?php

declare(strict_types=1);

namespace App\Tests\Unit\Metric\Factory;

use App\Metric\Dto\CreateMetricDtoInterface;
use App\Metric\Entity\Metric;
use App\Metric\Factory\MetricFactoryDirector;
use App\Metric\Factory\MetricFactoryInterface;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Metric\Factory\MetricFactoryDirector */
final class MetricFactoryDirectorTest extends TestCase
{
    public function testCreateWithSupportedFactory(): void
    {
        // Create a mock for CreateMetricDtoInterface
        $dto = $this->createMock(CreateMetricDtoInterface::class);
        $dto->method('getType')->willReturn('supported_type');
        $dto->method('getValue')->willReturn(42);

        // Create a mock for a MetricFactoryInterface
        $factory = $this->createMock(MetricFactoryInterface::class);
        $factory->method('supports')->willReturnCallback(
            fn ($type) => $type === 'supported_type'
        );
        $factory->method('create')->willReturnCallback(
            fn ($type, $value, $date) =>
            new Metric($type, $value, $date)
        );

        // Create the Factory with the mock factory
        $factory = new MetricFactoryDirector([$factory]);

        // Test the create method
        $metric = $factory->create($dto);
        $this->assertInstanceOf(Metric::class, $metric);
        $this->assertEquals('supported_type', $metric->getType());
        $this->assertEquals(42, $metric->getValue());
    }

    public function testCreateWithUnsupportedFactory(): void
    {
        // Create a mock for CreateMetricDtoInterface
        $dto = $this->createMock(CreateMetricDtoInterface::class);
        $dto->method('getType')->willReturn('unsupported_type');

        // Create a mock for a MetricFactoryInterface
        $factory = $this->createMock(MetricFactoryInterface::class);
        $factory->method('supports')->willReturnCallback(
            fn ($type) => $type === 'supported_type'
        );

        // Create the Factory with the mock factory
        $factory = new MetricFactoryDirector([$factory]);

        // Test that an exception is thrown when an unsupported type is used
        $this->expectException(DomainException::class);
        $factory->create($dto);
    }

    public function testCreateWithDefaultDate(): void
    {
        // Create a mock for CreateMetricDtoInterface
        $dto = $this->createMock(CreateMetricDtoInterface::class);
        $dto->method('getType')->willReturn('supported_type');
        $dto->method('getValue')->willReturn(42);

        // Create a mock for a MetricFactoryInterface
        $factory = $this->createMock(MetricFactoryInterface::class);
        $factory->method('supports')->willReturnCallback(
            fn ($type) => $type === 'supported_type'
        );
        $factory->method('create')->willReturnCallback(
            fn ($type, $value, $date) =>
            new Metric($type, $value, $date)
        );

        // Create the Factory with the mock factory
        $factory = new MetricFactoryDirector([$factory]);

        // Test that the default date is used when not provided
        $metric = $factory->create($dto);
        $this->assertInstanceOf(Metric::class, $metric);
        $this->assertEquals('supported_type', $metric->getType());
        $this->assertEquals(42, $metric->getValue());
        $this->assertInstanceOf(DateTimeImmutable::class, $metric->getTime());
    }
}
