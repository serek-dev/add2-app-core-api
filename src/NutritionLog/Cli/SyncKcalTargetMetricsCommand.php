<?php

declare(strict_types=1);


namespace App\NutritionLog\Cli;


use App\NutritionLog\Entity\Day;
use App\Shared\Integration\DomainEventsPublisherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:nl:metrics:sync-kcal-target', 'Iterates through all days and creates metrics for them')]
final class SyncKcalTargetMetricsCommand extends Command
{
    public function __construct(
        private readonly DomainEventsPublisherInterface $domainEventsPublisher, private readonly EntityManagerInterface $em
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repository = $this->em->getRepository(Day::class);

        $days = $repository->findAll();

        foreach ($days as $d) {
            $d->changeTarget($d->getTarget());
            $this->domainEventsPublisher->publishFrom($d);
        }

        return Command::SUCCESS;
    }
}
