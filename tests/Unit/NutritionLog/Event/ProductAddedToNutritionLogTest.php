<?php

declare(strict_types=1);

namespace NutritionLog\Event;

use App\NutritionLog\Event\ProductAddedToNutritionLog;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Event\ProductAddedToNutritionLog */
final class ProductAddedToNutritionLogTest extends TestCase
{
    public function testConstructor(): void
    {
        $event = new ProductAddedToNutritionLog(
            'productId',
            new DateTimeImmutable('2021-01-01'),
            100.0,
        );

        self::assertSame('productId', $event->getDayProductId());
        self::assertSame('2021-01-01', $event->getDate()->format('Y-m-d'));
        self::assertSame(100.0, $event->getKcal());
    }
}
