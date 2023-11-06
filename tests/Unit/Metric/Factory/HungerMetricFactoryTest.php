<?php

declare(strict_types=1);

namespace App\Tests\Unit\Metric\Factory;

use App\Metric\Entity\Metric;
use App\Metric\Factory\HungerMetricFactory;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Metric\Factory\HungerMetricFactory */
final class HungerMetricFactoryTest extends TestCase
{
    public function testSupportsValidType(): void
    {
        $factory = new HungerMetricFactory();
        $this->assertTrue($factory->supports('hunger'));
    }

    public function testSupportsInvalidType(): void
    {
        $factory = new HungerMetricFactory();
        $this->assertFalse($factory->supports('invalid_type'));
    }

    public function testCreateValidHungerMetric(): void
    {
        $factory = new HungerMetricFactory();
        $type = 'hunger';
        $value = 5;
        $date = new DateTimeImmutable();

        $metric = $factory->create($type, $value, $date);

        $this->assertInstanceOf(Metric::class, $metric);
        $this->assertEquals($type, $metric->getType());
        $this->assertEquals($value, $metric->getValue());
        $this->assertEquals($date, $metric->getTime());
    }

    /**
     * @dataProvider invalidHungerValues
     */
    public function testCreateInvalidHungerMetric($invalidValue): void
    {
        $factory = new HungerMetricFactory();
        $type = 'hunger';
        $date = new DateTimeImmutable();

        $this->expectException(DomainException::class);
        $factory->create($type, $invalidValue, $date);
    }

    public function invalidHungerValues(): array
    {
        // Define an array of invalid hunger values
        return [
            [-1],  // Negative value
            [0],   // Minimum valid value
            [11],  // Maximum valid value
            [15],  // Value above the valid range
        ];
    }
}
