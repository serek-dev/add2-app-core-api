<?php

namespace App\Tests\Diary\Command;

use App\Diary\Command\AddDayProductCommand;
use App\Diary\Dto\AddDayProductDtoInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Diary\Command\AddDayProductCommand */
final class AddDayProductCommandTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new AddDayProductCommand('date', '10:45', '1', 10.0);
        $this->assertInstanceOf(AddDayProductDtoInterface::class, $sut);
    }
}
