<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog\Specification\Product;

use App\Catalog\Persistence\Product\FindProductByNameInterface;
use App\Catalog\Specification\Product\UniqueNameSpecification;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Specification\Product\UniqueNameSpecification */
final class UniqueNameSpecificationTest extends TestCase
{
    public function testIsSatisfiedBy(): void
    {
        $specification = new UniqueNameSpecification(
            $find = $this->createMock(FindProductByNameInterface::class)
        );

        $find->expects(self::once())
            ->method('findByName')
            ->with('user-id', 'name')
            ->willReturn(null);

        self::assertTrue($specification->isSatisfiedBy(
            ProductTestHelper::createProductEntity('id-1', 'name')
        ));
    }

    public function testThrowsDuplicateError(): void
    {
        $specification = new UniqueNameSpecification(
            $find = $this->createMock(FindProductByNameInterface::class)
        );

        $find->expects(self::once())
            ->method('findByName')
            ->with('user-id', 'Product name')
            ->willReturn(ProductTestHelper::createProductEntity('id-1', 'name'));

        $this->expectExceptionMessage('Product with name: Product name already exist');
        $specification->isSatisfiedBy(
            ProductTestHelper::createProductEntity('name')
        );
    }
}
