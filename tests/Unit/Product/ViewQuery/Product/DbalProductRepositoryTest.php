<?php

namespace App\Tests\Unit\Product\ViewQuery\Product;

use App\Product\ViewQuery\Product\FindProductsInterface;
use App\Product\ViewQuery\Product\OrmProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Product\ViewQuery\Product\OrmProductRepository */
final class DbalProductRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new OrmProductRepository($this->createMock(EntityManagerInterface::class));
        $this->assertInstanceOf(FindProductsInterface::class, $sut);
    }
}
