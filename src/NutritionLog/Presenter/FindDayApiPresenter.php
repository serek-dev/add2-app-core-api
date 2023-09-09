<?php

declare(strict_types=1);


namespace App\NutritionLog\Presenter;


use App\NutritionLog\ViewQuery\Day\FindDayViewInterface;

final class FindDayApiPresenter
{
    public function __construct(
        private readonly FindDayViewInterface $findDay,
    ) {
    }

    public function render(string $date): array
    {
        $view = $this->findDay->findDay($date);

        $grouped = [];

        foreach ($view->getProducts() as $product) {
            $grouped[$product->consumptionTime][] = $product->jsonSerialize();
        }
        foreach ($view->getMeals() as $meal) {
            $grouped[$meal->consumptionTime][] = $meal->jsonSerialize();
        }

        $view = array_merge($view->jsonSerialize(), ['products' => $grouped]);
        unset($view['meals']);

        return [
            'item' => $view,
        ];
    }
}
