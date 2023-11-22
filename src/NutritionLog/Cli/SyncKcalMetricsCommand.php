<?php

declare(strict_types=1);


namespace App\NutritionLog\Cli;


use App\NutritionLog\Entity\Day;
use App\NutritionLog\Entity\DayMealProduct;
use App\NutritionLog\Entity\DayProduct;
use App\NutritionLog\Event\ProductAddedToNutritionLog;
use App\NutritionLog\Event\ProductsAddedToNutritionLog;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use function array_map;

#[AsCommand('app:nl:metrics:sync-kcal', 'Iterates through all days and creates metrics for them')]
final class SyncKcalMetricsCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $integrationEventBus, private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repository = $this->em->getRepository(Day::class);

        $days = $repository->findAll();

        foreach ($days as $d) {
            $products = $d->getProducts();

            $this->integrationEventBus->dispatch(
                new ProductsAddedToNutritionLog(
                    array_map(fn(DayProduct $p) => new ProductAddedToNutritionLog(
                        $p->getId(),
                        DateTimeImmutable::createFromFormat('Y-m-d H:i', $d->getDate() . ' ' . $p->getConsumptionTime()),
                        $p->getNutritionValues()->getKcal()), $products
                    )
                ));

            foreach ($d->getMeals() as $meal) {
                $this->integrationEventBus->dispatch(
                    new ProductsAddedToNutritionLog(
                        array_map(fn(DayMealProduct $p) => new ProductAddedToNutritionLog(
                            $p->getId(),
                            DateTimeImmutable::createFromFormat('Y-m-d H:i', $d->getDate() . ' ' . $meal->getConsumptionTime()),
                            $p->getKcal()), $meal->getProducts(),
                        )
                    ));
            }
        }

        return Command::SUCCESS;
    }
}
