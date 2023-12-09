<?php

declare(strict_types=1);


namespace App\NutritionLog\Presenter;


use App\NutritionLog\ViewQuery\Day\FindDayViewInterface;
use function uksort;

final class FindDayApiPresenter
{
    public function __construct(
        private readonly FindDayViewInterface $findDay,
    )
    {
    }

    public function render(string $date, string $userId): array
    {
        $view = $this->findDay->findByDateAndUser($date, $userId);

        $grouped = [];

        foreach ($view->getProducts() as $product) {
            $grouped[$product->consumptionTime][] = $product->jsonSerialize();
        }
        foreach ($view->getMeals() as $meal) {
            $grouped[$meal->consumptionTime][] = $meal->jsonSerialize();
        }

        uksort($grouped, function (string $a, string $b) {
            $timeA = strtotime($a);
            $timeB = strtotime($b);
            if ($timeA == $timeB) {
                return 0;
            }
            return ($timeA < $timeB) ? -1 : 1;
        });

        $view = array_merge($view->jsonSerialize(), ['products' => $grouped]);
        unset($view['meals']);

        return [
            'item' => $view,
        ];
    }
}
