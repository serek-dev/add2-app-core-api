<?php

declare(strict_types=1);


namespace App\Product\ViewQuery\Meal;


use App\Product\Entity\Meal;
use App\Product\Exception\NotFoundException;
use App\Product\View\MealView;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

final class OrmMealRepository implements FindMealsInterface, GetOneMealInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /** @inheritDoc */
    public function findAll(?string $name = null): array
    {
        $qb = $this->em->getRepository(Meal::class)->createQueryBuilder('m');

        if ($name) {
            $qb->where(
                $qb->expr()->like('m.name', $qb->expr()->literal('%' . $name . '%'))
            );
        }

        $qb->orderBy('m.name', 'asc');

        return array_map(fn(Meal $row) => $this->createViewFrom($row), $qb->getQuery()->getResult());
    }

    public function getOne(string $id): MealView
    {
        $qb = $this->em->getRepository(Meal::class)->createQueryBuilder('m');

        try {
            $qb->where('m.id = :id')
                ->setParameter('id', $id)
                ->setMaxResults(1);

            /** @var Meal $res */
            $row =
                $qb
                    ->getQuery()
                    ->getSingleResult();
        } catch (NoResultException $e) {
            throw new NotFoundException();
        }

        return $this->createViewFrom($row);
    }

    private function createViewFrom(Meal $row): MealView
    {
        $view = new MealView();

        $proteins = 0.0;
        $carbs = 0.0;
        $fats = 0.0;
        $kcal = 0.0;
        $weight = 0.0;

        foreach ($row->getProducts() as $p) {
            $v = $p->getNutritionValues();
            $proteins += $v->getProteins();
            $fats += $v->getFats();
            $carbs += $v->getCarbs();
            $kcal += $v->getKcal();
            $weight += $p->getWeight()->getRaw();
        }

        $view->setId($row->getId())
            ->setName($row->getName())
            ->setCarbs($carbs)
            ->setProteins($proteins)
            ->setFats($fats)
            ->setProducts($row->getProducts())
            ->setWeight($weight)
            ->setKcal($kcal);

        return $view;
    }
}
