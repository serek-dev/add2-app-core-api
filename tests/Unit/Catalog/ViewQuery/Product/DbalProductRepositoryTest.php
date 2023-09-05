<?php

namespace App\Tests\Unit\Catalog\ViewQuery\Product;

use App\Catalog\ViewQuery\Product\FindProductViewsInterface;
use App\Catalog\ViewQuery\Product\OrmProductViewRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\ViewQuery\Product\OrmProductViewRepository */
final class DbalProductRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new OrmProductViewRepository($this->createMock(EntityManagerInterface::class));
        $this->assertInstanceOf(FindProductViewsInterface::class, $sut);
    }
}
