<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Meal;


use App\Product\Entity\Meal;
use App\Product\View\MealView;
use Doctrine\ORM\EntityManagerInterface;

final class OrmMealRepository implements FindMealsInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /** @inheritDoc */
    public function findAll(?string $name = null): array
    {
        $qb = $this->em->getRepository(Meal::class)->createQueryBuilder('m');

//        $qb->join(MealProduct::class, 'meal_product', Join::WITH);

        if ($name) {
            $qb->where(
                $qb->expr()->like('m.name', $qb->expr()->literal('%' . $name . '%'))
            );
        }

        $qb->orderBy('m.name', 'asc');

        return array_map(function (Meal $row) {
            $view = new MealView();

            $proteins = 0.0;
            $carbs = 0.0;
            $fats = 0.0;
            $kcal = 0.0;

            foreach ($row->getProducts() as $p) {
                $v = $p->getNutritionValues();
                $proteins += $v->getProteins();
                $fats += $v->getFats();
                $carbs += $v->getCarbs();
                $kcal += $v->getKcal();
            }

            $view->setId($row->getId())
                ->setName($row->getName())
                ->setCarbs($carbs)
                ->setProteins($proteins)
                ->setFats($fats)
                ->setKcal($kcal);

            return $view;
        },
            $qb
                ->getQuery()
                ->getResult());
    }
}
