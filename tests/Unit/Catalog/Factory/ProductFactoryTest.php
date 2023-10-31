<?php

namespace App\Tests\Unit\Catalog\Factory;

use App\Catalog\Command\CreateProductCommand;
use App\Catalog\Dto\CreateProductDtoInterface;
use App\Catalog\Entity\Product;
use App\Catalog\Exception\DuplicateException;
use App\Catalog\Exception\InvalidArgumentException;
use App\Catalog\Factory\ProductFactory;
use App\Catalog\Persistence\Product\FindProductByIdInterface;
use App\Catalog\Persistence\Product\FindProductByNameInterface;
use App\Catalog\Specification\Product\NutritionMistakeThresholdSpecification;
use App\Catalog\Specification\Product\UniqueIdSpecification;
use App\Catalog\Specification\Product\UniqueNameSpecification;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Portion;
use App\Tests\Data\ProductTestHelper;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Factory\ProductFactory */
final class ProductFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $sut = new ProductFactory();

        $actual = $sut->create($this->getDto());

        $this->assertInstanceOf(Product::class, $actual);
    }

    public function testIdGenerationOnNull(): void
    {
        $sut = new ProductFactory();

        $actual = $sut->create($this->getDto());

        $this->assertStringContainsString('P-', $actual->getId());
    }

    public function testIdGenerationOnPassedValue(): void
    {
        $sut = new ProductFactory();

        $actual = $sut->create($this->getDto('P-123'));

        $this->assertStringContainsString('P-123', $actual->getId());
    }

    public function testCreateWithInvalidKcalSum(): void
    {
        // Given I have wrong sum kcal value

        $sut = new ProductFactory(
            [
                new NutritionMistakeThresholdSpecification(),
            ]
        );

        // Then I should be an invalid argument exception
        $this->expectException(InvalidArgumentException::class);

        // When I create new entity
        $sut->create(
            new CreateProductCommand(
                'Product',
                20.0,
                20.0,
                30.0,
                ((20 * 4) + (20 * 9) + (30 * 4)) * 2,
                '',
                null,
                null,
                null,
            )
        );
    }

    public function testCreateOnNonUniqueName(): void
    {
        // Given I have an existing product
        $findProductByName = $this->createMock(FindProductByNameInterface::class);
        $findProductByName
            ->method('findByName')
            ->with('name', 'product name')
            ->willReturn(ProductTestHelper::createProductEntity());

        // And my factory
        $sut = new ProductFactory(
            [
                new UniqueNameSpecification($findProductByName),
            ]
        );

        // Then I should see a duplicate exception
        $this->expectException(DuplicateException::class);

        // When I create a new entity
        $sut->create($this->getDto());
    }

    public function testCreateOnNonUniqueId(): void
    {
        // Given I have an existing product
        $findProductById = $this->createMock(FindProductByIdInterface::class);
        $findProductById
            ->method('findById')
            ->willReturn(ProductTestHelper::createProductEntity('P-123'));

        // And my factory
        $sut = new ProductFactory(
            [
                new UniqueIdSpecification($findProductById),
            ]
        );

        // Then I should see a duplicate exception
        $this->expectException(DuplicateException::class);
        $this->expectExceptionMessage('Product with id: P-123 already exist');

        // When I create a new entity
        $sut->create($this->getDto('P-123'));
    }

    private function getDto(?string $id = null): CreateProductDtoInterface
    {
        return new class($id) implements CreateProductDtoInterface {

            public function __construct(private readonly ?string $id = null)
            {
            }

            public function getNutritionValues(): NutritionalValues
            {
                return ProductTestHelper::createNutritionValues();
            }

            public function getName(): string
            {
                return 'name';
            }

            public function getProducerName(): ?string
            {
                return 'product name';
            }

            public function getId(): ?string
            {
                return $this->id;
            }

            public function getPortion(): ?Portion
            {
                return null;
            }
        };
    }
}
