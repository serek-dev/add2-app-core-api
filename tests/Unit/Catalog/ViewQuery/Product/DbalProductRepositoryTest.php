<?php

namespace App\Tests\Unit\Catalog\ViewQuery\Product;

use App\Catalog\ViewQuery\Product\FindProductsInterface;
use App\Catalog\ViewQuery\Product\OrmProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\ViewQuery\Product\OrmProductRepository */
final class DbalProductRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new OrmProductRepository($this->createMock(EntityManagerInterface::class));
        $this->assertInstanceOf(FindProductsInterface::class, $sut);
    }
}
