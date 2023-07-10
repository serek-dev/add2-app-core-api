<?php

namespace App\Tests\Unit\NutritionLog\Command;

use App\NutritionLog\Command\AddDayProductCommand;
use App\NutritionLog\Dto\AddDayProductDtoInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\NutritionLog\Command\AddDayProductCommand */
final class AddDayProductCommandTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new AddDayProductCommand('date', '10:45', '1', 10.0);
        $this->assertInstanceOf(AddDayProductDtoInterface::class, $sut);
    }
}
