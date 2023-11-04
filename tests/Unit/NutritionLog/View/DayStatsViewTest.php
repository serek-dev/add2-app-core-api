<?php

declare(strict_types=1);

namespace App\Tests\Unit\NutritionLog\View;

use App\NutritionLog\View\DayStatsView;
use PHPUnit\Framework\TestCase;

final class DayStatsViewTest extends TestCase
{
    public function testFromArray(): void
    {
        $view = DayStatsView::fromArray([
            'date' => '2021-01-01',
            'kcal' => '100.0',
            'proteins' => '10.0',
            'fats' => '20.0',
            'carbs' => '30.0',
            'weight' => '32.0',
        ]);

        self::assertSame('2021-01-01', $view->date);
        self::assertSame(100, $view->kcal);
        self::assertSame(10, $view->proteins);
        self::assertSame(20, $view->fats);
        self::assertSame(30, $view->carbs);
        self::assertSame(32, $view->weight);
    }
}
