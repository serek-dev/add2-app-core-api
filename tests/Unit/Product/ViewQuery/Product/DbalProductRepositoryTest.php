<?php

namespace App\Tests\Unit\Product\ViewQuery\Product;

use App\Product\ViewQuery\Product\DbalProductRepository;
use App\Product\ViewQuery\Product\FindProductsInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\ViewQuery\Product\DbalProductRepository */
final class DbalProductRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new DbalProductRepository($this->createMock(EntityManagerInterface::class));
        $this->assertInstanceOf(FindProductsInterface::class, $sut);
    }
}
