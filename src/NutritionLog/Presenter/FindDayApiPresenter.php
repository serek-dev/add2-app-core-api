<?php

declare(strict_types=1);


namespace App\NutritionLog\Presenter;


use App\NutritionLog\View\MealProductView;
use App\NutritionLog\View\MealView;
use App\NutritionLog\ViewQuery\Day\FindDayInterface;
use App\NutritionLog\ViewQuery\Day\FindMealsInterface;

final class FindDayApiPresenter
{
    public function __construct(
        private readonly FindDayInterface $findDay,
        private readonly FindMealsInterface $findMeals,
    ) {
    }

    public function render(string $date): array
    {
        $view = $this->findDay->findDay($date)->jsonSerialize();

        $view['meals'] = array_map(function (MealView $meal): array {
            $v = $meal->jsonSerialize();

            $v['products'] = array_map(function (MealProductView $v): array {
                return $v->jsonSerialize();
            }, $this->findMeals->findMealProducts($meal->id));

            return $v;
        }, $this->findMeals->findMeals($date));

        return [
            'item' => $view,
        ];
    }
}
