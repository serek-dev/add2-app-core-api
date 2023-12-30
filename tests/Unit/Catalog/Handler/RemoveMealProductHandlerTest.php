<?php

declare(strict_types=1);

namespace App\Tests\Unit\Catalog\Handler;


use App\Catalog\Command\RemoveMealProductCommand;
use App\Catalog\Entity\Meal;
use App\Catalog\Entity\MealProduct;
use App\Catalog\Handler\RemoveMealProductHandler;
use App\Catalog\Persistence\Meal\FindMealByIdInterface;
use App\Catalog\Persistence\Meal\MealPersistenceInterface;
use App\Catalog\Value\NutritionalValues;
use App\Catalog\Value\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Handler\RemoveMealProductHandler */
final class RemoveMealProductHandlerTest extends TestCase
{
    public function testRemove(): void
    {
        $findMealById = $this->createMock(FindMealByIdInterface::class);
        $findMealById
            ->expects(self::once())
            ->method('findByIdAndUser')
            ->with('mealId', 'userId')
            ->willReturn(
                $meal = new Meal('mealId', 'mealName', 'user', null, [
                    new MealProduct(
                        'productId',
                        $w = new Weight(100.0),
                        new NutritionalValues($w, $w, $w, 100),
                        'name',
                        'parentId',
                        null,
                    )
                ]),
            );

        $persistence = $this->createMock(MealPersistenceInterface::class);
        $persistence
            ->expects(self::once())
            ->method('removeProduct')
            ->with($meal, 'productId');

        $sut = new RemoveMealProductHandler(
            $findMealById,
            $persistence,
        );

        $sut->__invoke(new RemoveMealProductCommand('mealId', 'productId', 'userId'));
    }
}
