<?php

declare(strict_types=1);


namespace App\Diary\ViewQuery\Day;


use App\Diary\View\DayView;
use Doctrine\ORM\EntityManagerInterface;

final class DbalDayRepository implements FindDayInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function findDay(string $date): DayView
    {
        $c = $this->em->getConnection();

        $stats = [
            'proteins' => 0.0,
            'fats' => 0.0,
            'carbs' => 0.0,
            'kcal' => 0.0,
            'mealsCount' => 0,
            'weight' => 0.0,
        ];

        $sql = "
select ddp.consumption_time, ddp.id, ddp.product_id, ddp.product_name, ddp.producer_name, ddp.weight, ddp.proteins, ddp.fats, ddp.carbs, ddp.kcal
from diary_day_product ddp
         left join diary_day dd on dd.id = ddp.day_id
WHERE `date` = '$date'
order by consumption_time
        ";

        $stmt = $c->prepare($sql);

        $products = $stmt->executeQuery()->fetchAllAssociative();

        foreach ($products as $product) {
            $keysToCount = array_keys($stats);
            foreach ($product as $key => $value) {
                if (in_array($key, $keysToCount)) {
                    $stats[$key] += $value;
                }
            }
            $stats['mealsCount']++;
        }

        $view = new DayView();
        $view->setDate($date);
        $view->setProducts($products);
        $view->setStats($stats);

        return $view;
    }
}
