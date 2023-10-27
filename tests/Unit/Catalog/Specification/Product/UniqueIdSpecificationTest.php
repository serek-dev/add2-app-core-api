<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog\Specification\Product;

use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Specification\Product\UniqueIdSpecification;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Specification\Product\UniqueIdSpecification */
final class UniqueIdSpecificationTest extends TestCase
{
    public function testIsSatisfiedBy(): void
    {
        $specification = new UniqueIdSpecification(
            $find = $this->createMock(FindProductByIdInterface::class)
        );

        $find->expects(self::once())
            ->method('findById')
            ->with('id-1')
            ->willReturn(null);

        self::assertTrue($specification->isSatisfiedBy(
            ProductTestHelper::createProductEntity('id-1')
        ));
    }

    public function testThrowsDuplicateError(): void
    {
        $specification = new UniqueIdSpecification(
            $find = $this->createMock(FindProductByIdInterface::class)
        );

        $find->expects(self::once())
            ->method('findById')
            ->with('id-1')
            ->willReturn(ProductTestHelper::createProductEntity('id-1'));

        $this->expectExceptionMessage('Product with id: id-1 already exist');
        $specification->isSatisfiedBy(
            ProductTestHelper::createProductEntity('id-1')
        );
    }
}
