<?php

declare(strict_types=1);

namespace Catalog\Command;

use App\Catalog\Command\AddMealProductCommand;
use App\Catalog\Value\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Command\AddMealProductCommand */
final class AddMealProductCommandTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $mealId = 'meal123';
        $productId = 'product456';
        $weight = 100.0;

        $command = new AddMealProductCommand($mealId, $productId, $weight);

        $this->assertSame($mealId, $command->getMealId());
        $this->assertSame($productId, $command->getProductId());
        $this->assertEquals(new Weight(100.0), $command->getWeight());
    }
}
