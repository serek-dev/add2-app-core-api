<?php

declare(strict_types=1);

namespace App\Tests\Unit\Metric\Factory;

use App\Metric\Entity\Metric;
use App\Metric\Factory\WeightMetricFactory;
use DateTimeImmutable;
use DomainException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Metric\Factory\WeightMetricFactory */
final class WeightMetricFactoryTest extends TestCase
{
    public function testSupportsValidType(): void
    {
        $factory = new WeightMetricFactory();
        $this->assertTrue($factory->supports('weight'));
    }

    public function testSupportsInvalidType(): void
    {
        $factory = new WeightMetricFactory();
        $this->assertFalse($factory->supports('invalid_type'));
    }

    public function testCreateValidWeightMetric(): void
    {
        $factory = new WeightMetricFactory();
        $type = 'weight';
        $value = 50.5;
        $date = new DateTimeImmutable();

        $metric = $factory->create($type, $value, $date, 'user-id', null, null);

        $this->assertInstanceOf(Metric::class, $metric);
        $this->assertEquals($type, $metric->getType());
        $this->assertEquals($value, $metric->getValue());
        $this->assertEquals($date, $metric->getTime());
        $this->assertEquals('user-id', $metric->getUserId());
    }

    /**
     * @dataProvider invalidWeightValues
     */
    public function testCreateInvalidWeightMetric($invalidValue): void
    {
        $factory = new WeightMetricFactory();
        $type = 'weight';
        $date = new DateTimeImmutable();

        $this->expectException(DomainException::class);
        $factory->create($type, $invalidValue, $date, 'user-id', null, null);
    }

    public function invalidWeightValues(): array
    {
        // Define an array of invalid weight values
        return [
            [4.9],    // Below the valid range
            [250.1],  // Above the valid range
            [0],      // Zero (outside valid range)
            [-5],     // Negative value (outside valid range)
        ];
    }
}
