<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;


use App\NutritionLog\View\DayView;
use App\NutritionLog\View\MealProductView;
use App\NutritionLog\View\MealView;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

final class DbalDayRepository implements FindDayInterface, FindMealsInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function findDay(string $date): DayView
    {
        $c = $this->em->getConnection();

        $sql = "
select day.id,day.date,
       (select sum(meal_product.proteins)) proteins,
       (select sum(meal_product.fats))     fats,
       (select sum(meal_product.carbs))    carbs,
       (select sum(meal_product.kcal))     kcal,
       (select sum(meal_product.weight))   weight
from nl_day day
left join nl_day_meal meal on day.id = meal.day_id
left join nl_day_meal_product meal_product on meal.id = meal_product.meal_id
where date = '$date'
group by day.id, day.date
order by day.date
        ";

        $stmt = $c->prepare($sql);

        return array_map(fn(array $r): DayView => DayView::fromArray($r), $stmt->executeQuery()->fetchAllAssociative())[0] ?? throw new Exception('Dunno what');
    }

    /** @inheritdoc */
    public function findMeals(string $date): array
    {
        $c = $this->em->getConnection();

        $sql = "
select ml.consumption_time, ml.meal_id id, ndm.day_id, ndm.name, nd.date,
       (select sum(ml.proteins)) proteins,
       (select sum(ml.fats)) fats,
       (select sum(ml.carbs)) carbs,
       (select sum(ml.kcal)) kcal,
       (select sum(ml.weight)) weight
from nl_day_meal_product ml
         left join nl_day_meal ndm on ndm.id = ml.meal_id
         left join nl_day nd on ndm.day_id = nd.id
         left join p_meal_product pmp on ml.meal_id = pmp.meal_id
where nd.date = '$date'
group by ml.consumption_time, ml.meal_id
order by consumption_time
        ";

        $stmt = $c->prepare($sql);

        return array_map(fn(array $r): MealView => MealView::fromArray($r), $stmt->executeQuery()->fetchAllAssociative());
    }

    /** @inheritdoc */
    public function findMealProducts(string $mealId): array
    {
        $c = $this->em->getConnection();

        $sql = "
select mp.id,
       mp.proteins,
       mp.fats,
       mp.carbs,
       mp.weight,
       mp.kcal,
       mp.product_id,
       mp.product_name,
       mp.producer_name,
       mp.consumption_time
from nl_day_meal_product mp
where mp.meal_id = '$mealId'
order by mp.consumption_time
        ";

        $stmt = $c->prepare($sql);

        return array_map(fn(array $r): MealProductView => MealProductView::fromArray($r), $stmt->executeQuery()->fetchAllAssociative());
    }
}
