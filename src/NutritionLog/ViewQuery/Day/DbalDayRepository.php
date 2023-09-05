<?php

declare(strict_types=1);


namespace App\NutritionLog\ViewQuery\Day;


use App\NutritionLog\View\DayMealView;
use App\NutritionLog\View\DayProductView;
use App\NutritionLog\View\DayView;
use Doctrine\ORM\EntityManagerInterface;

final class DbalDayRepository implements FindDayInterface, FindMealsInterface, FindProductsInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function findDay(string $date): DayView
    {
        $repo = $this->em->getRepository(DayView::class);
        return $repo->findOneBy(['date' => $date]) ?? DayView::createEmpty($date);
    }

    /** @inheritdoc */
    public function findMeals(string $date): array
    {
        return [];
        $c = $this->em->getConnection();

        // todo: something is wrong because when there are meals and products - day
        // summaries are invalid

        $sql = "
select ml.consumption_time, ml.meal_id id, ndm.day_id, ndm.name, nd.date,
       IFNULL((select sum(ml.proteins)),0) proteins,
       IFNULL((select sum(ml.fats)),0) fats,
       IFNULL((select sum(ml.carbs)),0) carbs,
       IFNULL((select sum(ml.kcal)),0) kcal,
       IFNULL((select sum(ml.weight)),0) weight
from nutrition_log_day_meal_product ml
         left join nutrition_log_day_meal ndm on ndm.id = ml.meal_id
         left join nutrition_log_day nd on ndm.day_id = nd.id
         left join p_meal_product pmp on ml.meal_id = pmp.meal_id
where nd.date = '$date'
group by ml.consumption_time, ml.meal_id
order by consumption_time
        ";

        $stmt = $c->prepare($sql);

        return array_map(fn(array $r): DayMealView => DayMealView::fromArray($r), $stmt->executeQuery()->fetchAllAssociative());
    }

    /** @inheritdoc */
    public function findMealProducts(string $mealId): array
    {
        return [];
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
from nutrition_log_day_meal_product mp
where mp.meal_id = '$mealId'
order by mp.consumption_time
        ";

        $stmt = $c->prepare($sql);

        return array_map(fn(array $r): DayProductView => DayProductView::fromArray($r), $stmt->executeQuery()->fetchAllAssociative());
    }

    /** @inheritdoc */
    public function findProducts(string $date): array
    {
        return [];
        $c = $this->em->getConnection();

        $sql = "
select d.consumption_time,
       d.id,
       d.product_id,
       d.product_name,
       d.producer_name,
       d.weight,
       d.proteins,
       d.fats,
       d.carbs,
       d.kcal
from nutrition_log_day_product d
         left join nutrition_log_day dd on dd.id = d.day_id
WHERE `date` = '$date'
order by consumption_time
        ";

        $stmt = $c->prepare($sql);

        return array_map(fn(array $r): DayProductView => DayProductView::fromArray($r), $stmt->executeQuery()->fetchAllAssociative());
    }
}
