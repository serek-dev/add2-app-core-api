<?php

declare(strict_types=1);


namespace App\NutritionLog\Presenter;


use App\NutritionLog\ViewQuery\Day\FindDayInterface;
use App\NutritionLog\ViewQuery\Day\FindMealsInterface;
use App\NutritionLog\ViewQuery\Day\FindProductsInterface;

final class FindDayApiPresenter
{
    public function __construct(
        private readonly FindDayInterface $findDay,
        private readonly FindMealsInterface $findMeals,
        private readonly FindProductsInterface $findProducts,
    ) {
    }

    public function render(string $date): array
    {
        $view = $this->findDay->findDay($date)->jsonSerialize();

//        $view['meals'] = array_map(function (DayMealView $meal): array {
//            $v = $meal->jsonSerialize();
//
//            $v['products'] = array_map(function (DayProductView $v): array {
//                return $v->jsonSerialize();
//            }, $this->findMeals->findMealProducts($meal->id));
//
//            return $v;
//        }, $this->findMeals->findMeals($date));
//
//        $view['products'] = array_map(function (DayProductView $v) {
//            return $v->jsonSerialize();
//        }, $this->findProducts->findProducts($date));

        return [
            'item' => $view,
        ];
    }
}
