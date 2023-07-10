<?php

declare(strict_types=1);


namespace App\NutritionLog\Cli;


use App\NutritionLog\Command\AddDayMealCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand('app:diary:add-meal', 'Adds meal to nutrition day')]
final class AddDayMeal extends Command
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new AddDayMealCommand(
            '2023-07-06',
            '10:00',
            'M-64abefe0b8be3',
        );

        $this->bus->dispatch($command);

        return Command::SUCCESS;
    }
}
